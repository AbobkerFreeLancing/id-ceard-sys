<?php

namespace Packages\Accounting\Database\Seeders;

use Packages\Accounting\Models\Account;
use Illuminate\Database\Seeder;
use Packages\Accounting\Models\FinancialYear;

class FinancialYearSeeder extends Seeder
{
    public function run()
    {
        FinancialYear::create(['name' => '2026', 'start_date' => '01-01-2026']);
        // FinancialYear::create(['name' => '2027', 'start_date' => '01-01-2027']);
    }
}
