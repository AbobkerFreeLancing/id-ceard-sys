<?php

namespace App\Models;

use App\Enums\ReissueReason;
use App\Enums\ReissueStatus;
use Database\Factories\CardReissueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardReissue extends Model
{
    /** @use HasFactory<CardReissueFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'reason' => ReissueReason::class,
            'status' => ReissueStatus::class,
        ];
    }

    public function oldCard(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'old_card_id');
    }

    public function newCard(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'new_card_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
