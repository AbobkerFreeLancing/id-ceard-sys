<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Accounting\Models\Account;
use Packages\Accounting\Models\Currency;
use Packages\Accounting\Models\FinancialYear;
use Packages\Common\Models\Customer;
use Packages\School\Models\AcademicYear;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'pause_api_register' => 'boolean',
            'pause_api_login' => 'boolean',
            'must_approve_sales_invoice' => 'boolean',
        ];
    }

    public function academic_year(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function financial_year(): BelongsTo
    {
        return $this->belongsTo(FinancialYear::class);
    }

    public function sales_default_account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'sales_default_account_id');
    }

    public function sales_default_customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'sales_default_customer_id');
    }

    public function sales_default_warehouse(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'sales_default_warehouse_account_id');
    }

    public function sales_default_currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'sales_default_currency_id');
    }

    public function sale_returns_default_account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'sale_returns_default_account_id');
    }

    public function purchases_default_account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'purchases_default_account_id');
    }

    public function purchase_returns_default_account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'purchase_returns_default_account_id');
    }
}
