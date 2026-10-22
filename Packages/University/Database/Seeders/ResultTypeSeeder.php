<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\ResultType;

class ResultTypeSeeder extends Seeder
{
    public function run()
    {
        ResultType::create([
            'name' => 'رئيسية',
            'name_en' => 'Main',
        ]);

        ResultType::create([
            'name' => 'دور ثاني',
            'name_en' => 'Second Session',
        ]);

        ResultType::create([
            'name' => 'تكميلي',
            'name_en' => 'Supplementary',
        ]);
        ResultType::create([
            'name' => 'ملاحق',
            'name_en' => 'Carryover',
        ]);
    }
}
