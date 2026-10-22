<?php

namespace Packages\Common\Database\Seeders;

use Packages\Common\Models\Dev;
use Illuminate\Database\Seeder;

class DevSettingsSeeder extends Seeder
{
    public function run()
    {
        Dev::create([
            'on_demo_mode' => true,
            'logo_height' => 45,
        ]);
    }
}
