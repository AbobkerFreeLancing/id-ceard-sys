<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\AcademicStatus;

class AcademicStatusSeeder extends Seeder
{
    public function run()
    {
        AcademicStatus::create([
            'name' => 'طلب جديد',
            'name_en' => 'New Application',
            'code' => 'new',
            'sort_order' => 1,
        ]);

        AcademicStatus::create([
            'name' => 'مسجل',
            'name_en' => 'Registered',
            'code' => 'reg',
            'sort_order' => 2,
        ]);

        AcademicStatus::create([
            'name' => 'مجمد',
            'name_en' => 'Postponed',
            'code' => 'pos',
            'sort_order' => 3,
        ]);

        AcademicStatus::create([
            'name' => 'منسحب',
            'name_en' => 'Withdrawn',
            'code' => 'wth',
            'sort_order' => 4,
        ]);

        AcademicStatus::create([
            'name' => 'منقطع عن الدراسة',
            'name_en' => 'Discontinued',
            'code' => 'dis',
            'sort_order' => 5,
        ]);

        AcademicStatus::create([
            'name' => 'إنذار أكاديمي',
            'name_en' => 'Academic Probation',
            'code' => 'PROB',
            'sort_order' => 6,
        ]);

        AcademicStatus::create([
            'name' => 'موقوف أكاديمياً',
            'name_en' => 'Academically Suspended',
            'code' => 'SUSP',
            'sort_order' => 7,
        ]);

        AcademicStatus::create([
            'name' => 'مفصول',
            'name_en' => 'Dismissed / Expelled',
            'code' => 'DISM',
            'sort_order' => 8,
        ]);

        AcademicStatus::create([
            'name' => 'خريج',
            'name_en' => 'Graduated',
            'code' => 'GRAD',
            'sort_order' => 9,
        ]);

        AcademicStatus::create([
            'name' => 'محول',
            'name_en' => 'Matior',
            'code' => 'MAT',
            'sort_order' => 10,
        ]);
    }
}
