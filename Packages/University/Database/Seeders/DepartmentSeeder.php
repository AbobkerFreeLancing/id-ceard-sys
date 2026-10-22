<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        Department::create([
            'college_id' => 1,
            'name' => 'قسم التمريض',
            'name_en' => 'Dep 01',
            'code' => 'Dep-01',
        ]);

        Department::create([
            'college_id' => 2,
            'name' => 'قسم المختبرات',
            'name_en' => 'Dep 02',
            'code' => 'Dep-02',
        ]);

        Department::create([
            'college_id' => 3,
            'name' => 'قسم القبالة',
            'name_en' => 'Dep 03',
            'code' => 'Dep-03',
        ]);

        Department::create([
            'college_id' => 4,
            'name' => 'قسم التخدير',
            'name_en' => 'Dep 04',
            'code' => 'Dep-04',
        ]);
    }
}
