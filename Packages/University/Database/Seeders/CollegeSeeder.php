<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Enums\CollegeProgramTypeEnum;
use Packages\University\Models\College;

class CollegeSeeder extends Seeder
{
    public function run()
    {
        College::create([
            'name' => 'كلية علوم التمريض',
            'name_en' => 'College of Nursing Sciences',
            'code' => 'nursing',
        ]);

        College::create([
            'name' => 'كلية علوم المختبرات الطبية',
            'name_en' => 'College of Medical Laboratory Sciences',
            'code' => 'laboratory',
        ]);

        College::create([
            'name' => 'كلية علوم القبالة',
            'name_en' => 'College of Midwifery Sciences',
            'code' => 'midwifery',
        ]);

        College::create([
            'name' => 'كلية التخدير',
            'name_en' => 'College of Anesthesia',
            'code' => 'anesthesia',
            'program_type' => CollegeProgramTypeEnum::Diploma->value,
        ]);
    }
}
