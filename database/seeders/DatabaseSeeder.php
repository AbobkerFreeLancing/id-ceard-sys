<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\Support\Database\Seeders\SupportTicketsPermissionsSeeder;
use Packages\Support\Database\Seeders\TicketCategorySeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // Common
            \Packages\Common\Database\Seeders\DevSettingsSeeder::class,
            \Packages\Common\Database\Seeders\BranchSeeder::class,
            \Packages\Common\Database\Seeders\ReligionSeeder::class,
            \Packages\Common\Database\Seeders\CountrySeeder::class,
            config('bedaya.accounting_enabled')
                ? \Packages\Accounting\Database\Seeders\CurrencySeeder::class
                : VoidSeeder::class,

            \Database\Seeders\PermissionSeeder::class,
            config('bedaya.accounting_enabled')
                ? \Packages\Accounting\Database\Seeders\AccountingPermissionsSeeder::class
                : VoidSeeder::class,
            config('bedaya.idcard_enabled')
                ? \Packages\IdCard\Database\Seeders\IdCardPermissionsSeeder::class
                : VoidSeeder::class,

            // Support Tickets
            config('bedaya.support_tickets_enabled') ? SupportTicketsPermissionsSeeder::class : VoidSeeder::class,
            config('bedaya.support_tickets_enabled') ? TicketCategorySeeder::class : VoidSeeder::class,

            RoleSeeder::class,
            UserSeeder::class,
            StateSeeder::class,
            RegionSeeder::class,

            // Accounting
            config('bedaya.accounting_enabled')
                ? \Packages\Accounting\Database\Seeders\TaxSeeder::class
                : VoidSeeder::class,
            config('bedaya.accounting_enabled')
                ? \Packages\Accounting\Database\Seeders\FinancialYearSeeder::class
                : VoidSeeder::class,
            config('bedaya.accounting_enabled')
                ? \Packages\Accounting\Database\Seeders\AccountSeeder::class
                : VoidSeeder::class,
            config('bedaya.accounting_enabled')
                ? \Packages\Accounting\Database\Seeders\PaymentMethodSeeder::class
                : VoidSeeder::class,
            config('bedaya.accounting_enabled')
                ? \Packages\Accounting\Database\Seeders\BankSeeder::class
                : VoidSeeder::class,
            \Packages\Common\Database\Seeders\CustomerSeeder::class,

            // ID Card Module Seeder
            config('bedaya.idcard_enabled')
                ? \Packages\IdCard\Database\Seeders\IdCardSeeder::class
                : VoidSeeder::class,

            SettingsSeeder::class,
        ]);
    }
}
