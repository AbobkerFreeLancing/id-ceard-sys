<?php

namespace Packages\Accounting\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReceiptVoucher extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public static function boot()
    {
        parent::boot();
        static::created(function (self $model) {
            $model->ref_number = 'RV-' . $model->id;
            $model->save();
        });
    }

    public function financial_year()
    {
        return $this->belongsTo(FinancialYear::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function giver_account()
    {
        return $this->belongsTo(Account::class);
    }

    public function receiver_account()
    {
        return $this->belongsTo(Account::class);
    }

    public function payment_account()
    {
        return $this->belongsTo(Account::class, 'payment_account_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
