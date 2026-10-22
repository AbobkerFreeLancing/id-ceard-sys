<?php

namespace Packages\IdCard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardBatch extends Model
{
    protected $table = 'idcard_batches';

    protected $fillable = [
        'batch_number',
        'card_template_id',
        'total_cards',
        'output_format',
        'pdf_file_path',
        'status',
        'generated_by',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(CardTemplate::class, 'card_template_id');
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'batch_id');
    }
}
