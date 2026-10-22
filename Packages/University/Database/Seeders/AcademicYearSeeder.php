<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\AcademicYear;

class AcademicYearSeeder extends Seeder
{
    public function run()
    {
        AcademicYear::create([
            'name' => '2026-2027',
            'is_current' => true,
        ]);

        AcademicYear::create([
            'name' => '2027-2028',
            'is_active' => false,
        ]);
    }
}
