<?php

namespace Packages\Accounting\Models;

use Packages\Traits\BelongsToBranchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;
    use BelongsToBranchTrait;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'balance_before' => 'decimal:2',
            'balance_after' => 'decimal:2',
        ];
    }

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function relatedTransaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function source_model()
    {
        return $this->morphTo();
    }

    public function direct_model()
    {
        return $this->morphTo();
    }

    public function getTypeLabelAttribute()
    {
        if ($this->type == 'debit') {
            return __('backend.debit');
        } elseif ($this->type == 'credit') {
            return __('backend.credit');
        }
    }
}
