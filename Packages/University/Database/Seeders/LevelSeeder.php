<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\Level;

class LevelSeeder extends Seeder
{
    public function run()
    {
        Level::create([
            'name' => 'السنة الأولى',
            'name_en' => 'First Year',
            'sort_order' => 1,
        ]);

        Level::create([
            'name' => 'السنة الثانية',
            'name_en' => 'Second Year',
            'sort_order' => 2,
        ]);

        Level::create([
            'name' => 'السنة الثالثة',
            'name_en' => 'Third Year',
            'sort_order' => 3,
        ]);

        Level::create([
            'name' => 'السنة الرابعة',
            'name_en' => 'Fourth Year',
            'sort_order' => 4,
        ]);

        Level::create([
            'name' => 'السنة الخامسة',
            'name_en' => 'Fifth Year',
            'sort_order' => 5,
        ]);

        Level::create([
            'name' => 'الخريجين',
            'name_en' => 'Graduates',
            'sort_order' => 6,
        ]);
    }
}
