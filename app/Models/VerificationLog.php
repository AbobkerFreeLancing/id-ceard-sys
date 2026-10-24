<?php

namespace App\Models;

use App\Enums\VerificationResult;
use Database\Factories\VerificationLogFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerificationLog extends Model
{
    /** @use HasFactory<VerificationLogFactory> */
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
            'result' => VerificationResult::class,
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'scanned_at' => 'datetime',
        ];
    }

    /**
     * Scope a query to only include valid verification logs.
     */
    public function scopeValid(Builder $query): Builder
    {
        return $query->where('result', VerificationResult::Valid);
    }

    /**
     * Scope a query to filter suspicious or failed verification attempts.
     */
    public function scopeSuspicious(Builder $query): Builder
    {
        return $query->whereIn('result', [
            VerificationResult::Revoked,
            VerificationResult::Unknown,
            VerificationResult::InvalidSignature,
        ]);
    }

    /**
     * Scope a query to get recent scans within given hours.
     */
    public function scopeRecent(Builder $query, int $hours = 24): Builder
    {
        return $query->where('scanned_at', '>=', now()->subHours($hours));
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function scanner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
