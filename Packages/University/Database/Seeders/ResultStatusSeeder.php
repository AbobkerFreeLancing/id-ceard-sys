<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\ResultStatus;

class ResultStatusSeeder extends Seeder
{
    public function run()
    {
        ResultStatus::create([
            'name' => 'مسودة',
            'short_description' => 'قيد الإدخال',
        ]);

        ResultStatus::create([
            'name' => 'مراجعة',
            'short_description' => 'قيد المراجعة',
        ]);

        ResultStatus::create([
            'name' => 'مدققة',
            'short_description' => 'النتيجة مدققة',
        ]);

        ResultStatus::create([
            'name' => 'معتمدة',
            'short_description' => 'معتمدة رسمياً',
        ]);
    }
}
