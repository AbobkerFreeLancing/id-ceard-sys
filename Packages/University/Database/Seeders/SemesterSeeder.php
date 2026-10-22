<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\Semester;

class SemesterSeeder extends Seeder
{
    public function run()
    {
        Semester::create([
            'name' => 'الفترة الأولى',
            'name_en' => 'First Semester',
            'sort_order' => 1,
        ]);

        Semester::create([
            'name' => 'الفترة الثانية',
            'name_en' => 'Second Semester',
            'sort_order' => 2,
        ]);

        Semester::create([
            'name' => 'الفترة الثالثة',
            'name_en' => 'Third Semester',
            'sort_order' => 3,
        ]);

        Semester::create([
            'name' => 'الفترة الرابعة',
            'name_en' => 'Fourth Semester',
            'sort_order' => 4,
        ]);

        Semester::create([
            'name' => 'الفترة الخامسة',
            'name_en' => 'Fifth Semester',
            'sort_order' => 5,
        ]);

        Semester::create([
            'name' => 'الفترة السادسة',
            'name_en' => 'Sixth Semester',
            'sort_order' => 6,
        ]);

        Semester::create([
            'name' => 'الفترة السابعة',
            'name_en' => 'Seventh Semester',
            'sort_order' => 7,
        ]);

        Semester::create([
            'name' => 'الفترة الثامنة',
            'name_en' => 'Eighth Semester',
            'sort_order' => 8,
        ]);

        Semester::create([
            'name' => 'الفترة التاسعة',
            'name_en' => 'Ninth Semester',
            'sort_order' => 9,
        ]);

        Semester::create([
            'name' => 'الفترة العاشرة',
            'name_en' => 'Tenth Semester',
            'sort_order' => 10,
        ]);
    }
}
