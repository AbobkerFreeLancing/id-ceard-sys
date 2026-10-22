<?php

namespace Packages\IdCard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packages\IdCard\Enums\CardStatusEnum;

class Card extends Model
{
    protected $table = 'idcard_cards';

    protected $fillable = [
        'cardholder_id',
        'card_template_id',
        'batch_id',
        'card_uid',
        'card_number',
        'rfid_chip_code',
        'barcode_value',
        'qr_token',
        'issue_date',
        'expiry_date',
        'status',
        'print_count',
        'last_printed_at',
        'reissue_reason',
        'created_by',
        'approved_by',
    ];

    protected $casts = [
        'status' => CardStatusEnum::class,
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'last_printed_at' => 'datetime',
        'print_count' => 'integer',
    ];

    public function cardholder(): BelongsTo
    {
        return $this->belongsTo(Cardholder::class, 'cardholder_id');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(CardTemplate::class, 'card_template_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(CardBatch::class, 'batch_id');
    }

    public function reissues(): HasMany
    {
        return $this->hasMany(CardReissue::class, 'original_card_id');
    }

    public function verificationLogs(): HasMany
    {
        return $this->hasMany(VerificationLog::class, 'card_id');
    }

    public function isExpired(): bool
    {
        return $this->expiry_date->isPast();
    }

    public function isValidForVerification(): bool
    {
        return $this->status === CardStatusEnum::Active && !$this->isExpired();
    }
}
