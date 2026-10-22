<?php

namespace Packages\University\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Packages\Accounting\Models\Bank;
use Packages\Accounting\Models\Currency;

class Payment extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
        ];
    }

    public static function boot()
    {
        parent::boot();
        static::created(function (self $model) {
            $model->ref_number = date('YmdHi') . random_int(10, 99);
            $model->save();
        });
    }

    public function charge(): BelongsTo
    {
        return $this->belongsTo(StudentCharge::class, 'student_charge_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
