<?php

namespace Packages\Accounting\Database\Seeders;

use Packages\Accounting\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        PaymentMethod::create(['name' => 'نقداً', 'slug' => 'cash']);
        PaymentMethod::create(['name' => 'تحويل بنكي', 'slug' => 'bank']);
        PaymentMethod::create(['name' => 'شيك', 'slug' => 'cheque']);
    }
}
