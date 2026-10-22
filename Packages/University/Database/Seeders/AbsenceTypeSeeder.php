<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\AbsenceType;

class AbsenceTypeSeeder extends Seeder
{
    public function run()
    {
        AbsenceType::create([
            'name' => 'غياب بعذر',
            'name_en' => 'Excused absence',
            'code' => 'excused',
            'is_enabled' => true,
        ]);

        AbsenceType::create([
            'name' => 'غياب بدون عذر',
            'name_en' => 'Unexcused absence',
            'code' => 'unexcused',
            'is_enabled' => true,
        ]);

        AbsenceType::create([
            'name' => 'غياب مرضي',
            'name_en' => 'Sick absence',
            'code' => 'sick',
            'is_enabled' => false,
        ]);
    }
}
