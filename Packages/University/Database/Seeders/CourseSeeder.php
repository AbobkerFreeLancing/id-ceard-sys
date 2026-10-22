<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\Course;

class CourseSeeder extends Seeder
{
    public function run()
    {
        Course::create([
            'name' => 'مقرر الصحة العامة',
            'name_en' => 'General Health',
            'code' => 'GH',
            'credit_hours' => 11,
            'sort_order' => 1,
        ]);

        Course::create([
            'name' => 'مقرر علوم المختبرات',
            'name_en' => 'LAB',
            'code' => 'LAB',
            'credit_hours' => 10,
            'sort_order' => 2,
        ]);

        Course::create([
            'name' => 'الكيمياء الحيوية',
            'name_en' => 'ch',
            'code' => 'ch',
            'credit_hours' => 10,
            'sort_order' => 3,
        ]);

        Course::create([
            'name' => 'رعاية حديثي الولادة',
            'name_en' => 'bb',
            'code' => 'bb',
            'credit_hours' => 15,
            'sort_order' => 4,
        ]);

        Course::create([
            'name' => 'اللغة الإنجليزية الطبية',
            'name_en' => 'eng',
            'code' => 'eng',
            'credit_hours' => 9,
            'sort_order' => 5,
        ]);

        Course::create([
            'name' => 'مهارات الحاسوب',
            'name_en' => 'it',
            'code' => 'it',
            'credit_hours' => 12,
            'sort_order' => 6,
        ]);
    }
}
