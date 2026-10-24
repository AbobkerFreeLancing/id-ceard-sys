<?php

namespace App\Models;

use App\Enums\TemplateOrientation;
use Database\Factories\CardTemplateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardTemplate extends Model
{
    /** @use HasFactory<CardTemplateFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'idcard_templates';

    protected $guarded = ['id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'orientation' => TemplateOrientation::class,
            'width_mm' => 'decimal:2',
            'height_mm' => 'decimal:2',
            'dpi' => 'integer',
            'layout' => 'array',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'template_id');
    }

    public function batches(): HasMany
    {
        return $this->hasMany(CardBatch::class, 'template_id');
    }
}
