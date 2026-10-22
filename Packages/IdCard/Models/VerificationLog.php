<?php

namespace Packages\IdCard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Packages\IdCard\Enums\VerificationStatusEnum;

class VerificationLog extends Model
{
    protected $table = 'idcard_verification_logs';

    public $timestamps = false;

    protected $fillable = [
        'card_id',
        'scanned_token',
        'verifier_user_id',
        'verification_status',
        'scanner_ip',
        'user_agent',
        'device_type',
        'location_latitude',
        'location_longitude',
        'scanned_at',
    ];

    protected $casts = [
        'verification_status' => VerificationStatusEnum::class,
        'scanned_at' => 'datetime',
        'location_latitude' => 'decimal:8',
        'location_longitude' => 'decimal:8',
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
}
