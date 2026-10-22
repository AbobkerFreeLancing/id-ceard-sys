<?php

namespace Packages\Common\Database\Seeders;

use Packages\Common\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run()
    {
        Branch::create([
            'name' => 'الفرع الرئيسي',
            'slug' => 'main',
            'is_editable' => false,
        ]);

        Branch::create([
            'name' => 'فرع المنارة',
            'slug' => 'second',
        ]);
    }
}
