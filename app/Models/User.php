<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return Permission::query()
            ->whereHas('roles', function ($query) {
                $query->whereIn('roles.id', $this->roles()->pluck('roles.id'));
            });
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('slug', $roles)->exists();
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->hasRole('super-admin')) {
            return true;
        }

        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('permissions.slug', $permission);
            })
            ->exists();
    }

    public function uploadedMedia(): HasMany
    {
        return $this->hasMany(Media::class, 'uploaded_by');
    }

    public function reviewedVolunteerApplications(): HasMany
    {
        return $this->hasMany(VolunteerApplication::class, 'reviewed_by');
    }

    public function handledContactSubmissions(): HasMany
    {
        return $this->hasMany(ContactSubmission::class, 'handled_by');
    }

    public function idempotencyKeys(): HasMany
    {
        return $this->hasMany(IdempotencyKey::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
}
