<?php

namespace Packages\IdCard\Database\Seeders;

use Illuminate\Database\Seeder;

class IdCardSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            IdCardPermissionsSeeder::class,
            IdCardDefaultTemplatesSeeder::class,
        ]);
    }
}
