<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's base authorization data and initial Super Admin.
     *
     * This seeder is intentionally idempotent:
     * - Roles and permissions are upserted by RolePermissionSeeder.
     * - Role/permission assignments are synchronized to the finalized design.
     * - The Super Admin user is created only when the configured email does not exist.
     * - Existing Super Admin passwords are not overwritten on subsequent runs.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
