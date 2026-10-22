<?php

namespace Packages\Accounting\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Alkoumi\LaravelArabicNumbers\Numbers;
use Packages\Traits\BelongsToBranchTrait;

class Expense extends Model
{
    use HasFactory;
    use BelongsToBranchTrait;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
        ];
    }

    public static function boot()
    {
        parent::boot();
        static::created(function (self $model) {
            $model->ref_number = 'EXP-' . $model->id;
            $model->save();
        });
    }

    public function getAmountXAttribute()
    {
        return Numbers::TafqeetNumber($this->amount);
    }

    public function financial_year()
    {
        return $this->belongsTo(FinancialYear::class);
    }

    public function items()
    {
        return $this->hasMany(ExpenseItem::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function payment_account()
    {
        return $this->belongsTo(Account::class, 'payment_account_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    // public function type() {
    //     return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    // }
}
