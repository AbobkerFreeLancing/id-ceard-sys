<?php

namespace Packages\Accounting\Database\Seeders;

use Packages\Accounting\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    public function run()
    {
        Tax::create([
            'name' => 'ضريبة صفرية',
            'type' => 'percentage',
            'amount' => 0,
            'is_editable' => false,
        ]);

        Tax::create([
            'name' => 'ضريبة القيمة المضافة على الايرادات',
            'type' => 'percentage',
            'amount' => 15,
            'is_editable' => false,
        ]);

        Tax::create([
            'name' => 'غير خاضع للضريبة',
            'type' => 'percentage',
            'amount' => 0,
            'is_editable' => false,
        ]);
    }
}
