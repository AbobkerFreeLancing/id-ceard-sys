<?php

namespace Database\Seeders;

use App\Models\Setting;
use Packages\Accounting\Models\Account;
use Packages\Accounting\Models\Currency;
use Packages\Accounting\Models\FinancialYear;
use Packages\Common\Models\Customer;
use Packages\Warehouse\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        Setting::create([
            'company_name' => 'نظام هوية لإدارة والتحقق من البطاقات التعريفية',
            'tagline' => 'المنصة الذكية لإدارة وطباعة وفحص البطاقات التعريفية الموثقة',
            'description' => 'نظام متكامل لتوليد وتصميم وطباعة البطاقات الذكية والتحقق الرقمي الفوري عبر الـ QR Code المشفر',
            'company_address' => 'السودان، الخرطوم',
            'company_phones' => '0111122222 - 0933333333',
            'company_email' => 'info@huwia-id.net',
            'invoice_tagline' => 'نظام هوية الموثق للبطاقات التعريفية والتحقق الرقمي.',
            'financial_year_id' => Schema::hasTable('financial_years') ? FinancialYear::first()?->id : null,
            'currency_id' => Schema::hasTable('currencies') ? Currency::first()->id : null,
            'sales_default_currency_id' => Schema::hasTable('currencies') ? Currency::first()?->id : null,
            'sales_default_account_id' => Schema::hasTable('accounts')
                ? Account::whereHas('parent', fn($query) => $query->where('slug', 'acc_sales_revenue'))
                    ->where('is_enabled', 1)
                    ->first()?->id
                : null,
            'sales_default_customer_id' => Schema::hasTable('customers') ? Customer::first()?->id : null,
            'sales_default_warehouse_account_id' => Schema::hasTable('warehouses')
                ? Warehouse::enabled()?->first()?->id
                : null,
            'sale_returns_default_account_id' => Schema::hasTable('accounts')
                ? Account::whereHas('parent', fn($query) => $query->where('slug', 'acc_sales_returns'))
                    ->where('is_enabled', 1)
                    ->first()?->id
                : null,
            'purchases_default_account_id' => Schema::hasTable('accounts')
                ? Account::whereHas('parent', fn($query) => $query->where('slug', 'acc_purchases'))
                    ->where('is_enabled', 1)
                    ->first()?->id
                : null,
            'purchase_returns_default_account_id' => Schema::hasTable('accounts')
                ? Account::whereHas('parent', fn($query) => $query->where('slug', 'acc_purchases_returns'))
                    ->where('is_enabled', 1)
                    ->first()?->id
                : null,
        ]);
    }
}
