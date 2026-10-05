<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SCT_ADMIN_EMAIL');
        $password = env('SCT_ADMIN_PASSWORD');
        $name = env('SCT_ADMIN_NAME', 'SCT Super Admin');

        if (!$email) {
            throw new RuntimeException(
                'SCT_ADMIN_EMAIL is not set. Add it to .env before running the database seeders.'
            );
        }

        $role = Role::where('slug', 'super-admin')->firstOrFail();

        $user = User::where('email', $email)->first();

        if (!$user) {
            if (!$password) {
                throw new RuntimeException(
                    'SCT_ADMIN_PASSWORD is not set. Add it to .env before creating the initial Super Admin.'
                );
            }

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'status' => 'active',
            ]);
        } else {
            $user->forceFill([
                'name' => $name,
                'status' => 'active',
            ])->save();
        }

        $user->roles()->syncWithoutDetaching([$role->id]);
    }
}
