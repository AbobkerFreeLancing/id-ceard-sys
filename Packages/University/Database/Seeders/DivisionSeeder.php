<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\Division;

class DivisionSeeder extends Seeder
{
    public function run()
    {
        Division::create([
            'department_id' => 1,
            'name' => 'تخصص رقم 01',
            'name_en' => 'Specialization 01',
        ]);
    }
}
