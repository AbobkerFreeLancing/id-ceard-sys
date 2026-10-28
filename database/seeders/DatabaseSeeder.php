<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with modular seeders.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoleAndPermissionSeeder::class,
            OrganizationSeeder::class,
            DepartmentSeeder::class,
            CardTemplateSeeder::class,
            CardholderSeeder::class,
            CardSeeder::class,
            CardBatchSeeder::class,
            VerificationLogSeeder::class,
        ]);
    }
}
