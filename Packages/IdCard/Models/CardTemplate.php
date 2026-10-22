<?php

namespace Packages\IdCard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packages\IdCard\Enums\CardOrientationEnum;
use Packages\IdCard\Enums\CardTypeEnum;

class CardTemplate extends Model
{
    protected $table = 'idcard_templates';

    protected $fillable = [
        'organization_id',
        'name',
        'card_type',
        'orientation',
        'width_mm',
        'height_mm',
        'front_background_image',
        'back_background_image',
        'design_config_json',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'card_type' => CardTypeEnum::class,
        'orientation' => CardOrientationEnum::class,
        'width_mm' => 'decimal:2',
        'height_mm' => 'decimal:2',
        'design_config_json' => 'array',
        'is_active' => 'boolean',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function elements(): HasMany
    {
        return $this->hasMany(TemplateElement::class, 'card_template_id');
    }

    public function frontElements(): HasMany
    {
        return $this->hasMany(TemplateElement::class, 'card_template_id')->where('side', 'front');
    }

    public function backElements(): HasMany
    {
        return $this->hasMany(TemplateElement::class, 'card_template_id')->where('side', 'back');
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'card_template_id');
    }
}
