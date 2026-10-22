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
            \Packages\University\Database\Seeders\UniversityPermissionsSeeder::class,

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

            \Packages\University\Database\Seeders\AbsenceTypeSeeder::class,
            \Packages\University\Database\Seeders\FeeTypeSeeder::class,
            \Packages\University\Database\Seeders\ResultStatusSeeder::class,
            \Packages\University\Database\Seeders\ResultTypeSeeder::class,
            \Packages\University\Database\Seeders\GradeScaleSeeder::class,
            \Packages\University\Database\Seeders\AcademicStatusSeeder::class,
            \Packages\University\Database\Seeders\AcceptanceTypeSeeder::class,
            \Packages\University\Database\Seeders\CertificateTypeSeeder::class,
            \Packages\University\Database\Seeders\CourseSeeder::class,
            \Packages\University\Database\Seeders\LevelSeeder::class,
            \Packages\University\Database\Seeders\AcademicYearSeeder::class,
            \Packages\University\Database\Seeders\SemesterSeeder::class,
            \Packages\University\Database\Seeders\CollegeSeeder::class,
            \Packages\University\Database\Seeders\DepartmentSeeder::class,
            \Packages\University\Database\Seeders\DivisionSeeder::class,

            SettingsSeeder::class,
        ]);
    }
}
