<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packages\Accounting\Models\Currency;

class StudentCharge extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public static function boot()
    {
        parent::boot();
        static::created(function (StudentCharge $charge) {
            $charge->update([
                'ref_number' =>
                    $charge?->student->university_no . random_int(10, 99) . date('m') . date('y') . random_int(10, 99),
            ]);
        });
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function invoiceItem(): BelongsTo
    {
        return $this->belongsTo(InvoiceItem::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(academicYear::class);
    }

    public function semster(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function feeType(): BelongsTo
    {
        return $this->belongsTo(FeeType::class);
    }

    public function feeStructure(): BelongsTo
    {
        return $this->belongsTo(FeeStructure::class);
    }

    public function feeStructureItem(): BelongsTo
    {
        return $this->belongsTo(FeeStructureItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getPaymentsTotalAttribute()
    {
        return $this->has('payments') ? $this->payments->where('status', 'approved')->pluck('amount')->sum() : 0;
    }

    public function getPaymentsRemainingAttribute()
    {
        if ($this->has('payments')) {
            return $this->net_amount - $this->payments_total;
        } else {
            return $this->net_amount;
        }
    }
}
