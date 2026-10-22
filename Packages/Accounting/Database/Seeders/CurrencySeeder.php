<?php

namespace Packages\Accounting\Database\Seeders;

use Packages\Accounting\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        Currency::create(['name' => 'جنيه سوداني', 'symbol' => 'ج.س', 'part_name' => 'قرش', 'exchange_rate' => 1]);
        // Currency::create(['name' => 'دولار أمريكي', 'symbol' => 'USD', 'part_name' => 'سنت', 'exchange_rate' => 3600,'is_enabled' => false]);
        // Currency::create(['name' => 'ريال سعودي', 'symbol' => 'ر.س', 'part_name' => 'هللة', 'exchange_rate' => 800,'is_enabled' => false]);
        // Currency::create(['name' => 'يورو', 'symbol' => 'EUR', 'part_name' => 'يوروسنت', 'exchange_rate' => 3200,'is_enabled' => false]);
        // Currency::create(['name' => 'درهم إماراتي', 'symbol' => 'AED', 'part_name' => 'فلس', 'exchange_rate' => 890,'is_enabled' => false]);
        // Currency::create(['name' => 'جنيه مصري', 'symbol' => 'EGP', 'part_name' => 'قرش', 'exchange_rate' => 58,'is_enabled' => false]);
    }
}
