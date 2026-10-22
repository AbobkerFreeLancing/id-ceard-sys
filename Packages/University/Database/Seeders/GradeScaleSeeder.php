<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\GradeScale;

class GradeScaleSeeder extends Seeder
{
    public function run()
    {
        GradeScale::create([
            'grade' => 'أ',
            'grade_en' => 'A',
            'min_mark' => 80,
            'max_mark' => 100,
            'points' => 4.0,
            'estimation_ar' => 'ممتاز',
            'estimation_en' => 'Excellent',
        ]);

        GradeScale::create([
            'grade' => 'ب+',
            'grade_en' => 'B+',
            'min_mark' => 70,
            'max_mark' => 79,
            'points' => 3.5,
            'estimation_ar' => 'جيد جداً',
            'estimation_en' => 'Very Good',
        ]);

        GradeScale::create([
            'grade' => 'ب',
            'grade_en' => 'B',
            'min_mark' => 60,
            'max_mark' => 67,
            'points' => 3.0,
            'estimation_ar' => 'جيد',
            'estimation_en' => 'Good',
        ]);

        GradeScale::create([
            'grade' => 'ج+',
            'grade_en' => 'C+',
            'min_mark' => 55,
            'max_mark' => 59,
            'points' => 2.5,
            'estimation_ar' => 'مقبول مرتفع',
            'estimation_en' => 'High Pass',
        ]);

        GradeScale::create([
            'grade' => 'ج',
            'grade_en' => 'C',
            'min_mark' => 50,
            'max_mark' => 54,
            'points' => 2.0,
            'estimation_ar' => 'مقبول',
            'estimation_en' => 'Pass',
        ]);

        GradeScale::create([
            'grade' => 'هـ',
            'grade_en' => 'F',
            'min_mark' => 0,
            'max_mark' => 49,
            'points' => 0,
            'estimation_ar' => 'راسب',
            'estimation_en' => 'Fail',
            'is_pass' => 0,
        ]);
    }
}
