<?php

namespace Packages\IdCard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateElement extends Model
{
    protected $table = 'idcard_template_elements';

    protected $fillable = [
        'card_template_id',
        'side',
        'element_key',
        'label',
        'pos_x_mm',
        'pos_y_mm',
        'width_mm',
        'height_mm',
        'font_family',
        'font_size_pt',
        'font_weight',
        'color_hex',
        'text_align',
        'is_visible',
    ];

    protected $casts = [
        'pos_x_mm' => 'decimal:2',
        'pos_y_mm' => 'decimal:2',
        'width_mm' => 'decimal:2',
        'height_mm' => 'decimal:2',
        'font_size_pt' => 'decimal:1',
        'is_visible' => 'boolean',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(CardTemplate::class, 'card_template_id');
    }
}
