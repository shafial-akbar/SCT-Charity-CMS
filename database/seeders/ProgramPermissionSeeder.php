<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class ProgramPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Programs — View', 'slug' => 'programs.view', 'module' => 'programs', 'action' => 'view'],
            ['name' => 'Programs — Create', 'slug' => 'programs.create', 'module' => 'programs', 'action' => 'create'],
            ['name' => 'Programs — Update', 'slug' => 'programs.update', 'module' => 'programs', 'action' => 'update'],
            ['name' => 'Programs — Delete', 'slug' => 'programs.delete', 'module' => 'programs', 'action' => 'delete'],
            ['name' => 'Programs — Publish', 'slug' => 'programs.publish', 'module' => 'programs', 'action' => 'publish'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }
}
