<?php

namespace Packages\IdCard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardReissue extends Model
{
    protected $table = 'idcard_reissues';

    protected $fillable = [
        'original_card_id',
        'new_card_id',
        'reason',
        'notes',
        'fee_amount',
        'is_paid',
        'requested_by',
        'approved_by',
        'status',
    ];

    protected $casts = [
        'fee_amount' => 'decimal:2',
        'is_paid' => 'boolean',
    ];

    public function originalCard(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'original_card_id');
    }

    public function newCard(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'new_card_id');
    }
}
