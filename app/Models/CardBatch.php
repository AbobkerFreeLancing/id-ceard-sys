<?php

namespace App\Models;

use App\Enums\BatchStatus;
use Database\Factories\CardBatchFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardBatch extends Model
{
    /** @use HasFactory<CardBatchFactory> */
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
            'status' => BatchStatus::class,
            'cards_per_sheet' => 'integer',
            'total_cards' => 'integer',
            'printed_at' => 'datetime',
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(CardTemplate::class, 'template_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class, 'card_batch_items', 'batch_id', 'card_id')
            ->withPivot('position')
            ->withTimestamps();
    }

    public function items(): HasMany
    {
        return $this->hasMany(CardBatchItem::class, 'batch_id');
    }
}
