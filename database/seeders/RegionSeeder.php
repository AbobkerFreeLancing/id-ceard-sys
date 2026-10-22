<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run()
    {
        Region::create(['name' => 'أمدرمان', 'state_id' => 1]);
        Region::create(['name' => 'بحري', 'state_id' => 1]);
        Region::create(['name' => 'الكلاكلة', 'state_id' => 1]);
        Region::create(['name' => 'حنتوب', 'state_id' => 2]);
        Region::create(['name' => 'مدني', 'state_id' => 2]);
        Region::create(['name' => 'عطبرة', 'state_id' => 3]);
        Region::create(['name' => 'الدامر', 'state_id' => 3]);
    }
}
