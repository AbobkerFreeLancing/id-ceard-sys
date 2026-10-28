<?php

namespace App\Models;

use App\Enums\CardStatus;
use App\Observers\CardObserver;
use Database\Factories\CardFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([CardObserver::class])]
class Card extends Model
{
    /** @use HasFactory<CardFactory> */
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
            'status' => CardStatus::class,
            'issued_at' => 'datetime',
            'expires_at' => 'datetime',
            'print_count' => 'integer',
        ];
    }

    /**
     * Scope a query to only include active cards.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', CardStatus::Active);
    }

    /**
     * Scope a query to only include expired cards.
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('status', CardStatus::Expired)
            ->orWhere(function (Builder $q) {
                $q->whereNotNull('expires_at')
                    ->where('expires_at', '<', now());
            });
    }

    /**
     * Scope a query to only include revoked cards.
     */
    public function scopeRevoked(Builder $query): Builder
    {
        return $query->where('status', CardStatus::Revoked);
    }

    /**
     * Scope a query to find a card by its UID.
     */
    public function scopeByUid(Builder $query, string $cardUid): Builder
    {
        return $query->where('card_uid', $cardUid);
    }

    /**
     * Check if the card is currently valid for access.
     */
    public function isValid(): bool
    {
        return $this->status === CardStatus::Active
            && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function cardholder(): BelongsTo
    {
        return $this->belongsTo(Cardholder::class, 'cardholder_id');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(CardTemplate::class, 'template_id');
    }

    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(CardBatch::class, 'card_batch_items', 'card_id', 'batch_id')
            ->withPivot('position')
            ->withTimestamps();
    }

    public function batchItems(): HasMany
    {
        return $this->hasMany(CardBatchItem::class, 'card_id');
    }

    public function reissues(): HasMany
    {
        return $this->hasMany(CardReissue::class, 'old_card_id');
    }

    public function verificationLogs(): HasMany
    {
        return $this->hasMany(VerificationLog::class, 'card_id');
    }
}
