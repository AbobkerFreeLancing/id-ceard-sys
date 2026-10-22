<?php

namespace Packages\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AccountingPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Financial years
        Permission::create([
            'name' => 'financial_years_management',
            'label' => 'Financial years management',
            'label_ar' => 'السنوات المالية',
        ]);

        // Chart of accounts
        Permission::create([
            'name' => 'accounts_management',
            'label' => 'Accounts Management',
            'label_ar' => 'إدارة دليل الحسابات',
        ]);

        // Bank management
        Permission::create(['name' => 'bank_management', 'label' => 'Bank Management', 'label_ar' => 'إدارة البنوك']);

        // Balance transfer
        Permission::create([
            'name' => 'account_balance_transfer',
            'label' => 'Accounts balance transfer',
            'label_ar' => 'تحويل رصيد الحسابات',
        ]);

        // Currencies
        Permission::create([
            'name' => 'currency_management',
            'label' => 'Currency Management',
            'label_ar' => 'إدارة العملات',
        ]);

        // Journals
        Permission::create([
            'name' => 'journals_management',
            'label' => 'Journals Management',
            'label_ar' => 'إدارة قيود اليومية',
        ]);

        // safes
        Permission::create([
            'name' => 'safes_management',
            'label' => 'Safes management',
            'label_ar' => 'إدارة حساب الخزنة',
        ]);

        // Safe Balance view
        Permission::create([
            'name' => 'safe_balance_view',
            'label' => 'Safes balance view',
            'label_ar' => 'عرض رصيد الخزن',
        ]);

        // Expenses
        Permission::create([
            'name' => 'expense_management',
            'label' => 'Expense Management',
            'label_ar' => 'إدارة المصروفات',
        ]);

        // Receipt Vouchers
        Permission::create([
            'name' => 'receipt_vouchers_management',
            'label' => 'Receipt vouchers Management',
            'label_ar' => 'إدارة سندات القبض',
        ]);

        // Payment Approve
        Permission::create([
            'name' => 'payments_approve',
            'label' => 'Payments Approve',
            'label_ar' => 'اعتماد الدفعيات',
        ]);


        Permission::create([
            'name' => 'student_invoices_management',
            'label' => 'Student Invoices Management',
            'label_ar' => 'إدارة فواتير الطلاب',
        ]);

        Permission::create([
            'name' => 'student_payments_management',
            'label' => 'Student Payments Management',
            'label_ar' => 'إدارة مدفوعات الطلاب',
        ]);
    }
}
