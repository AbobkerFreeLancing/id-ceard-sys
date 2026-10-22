<?php

namespace Packages\DocsModule\Models;

use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasEnabledScope;

    protected $table = "docs_sections";

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean'
        ];
    }

    public static function boot()
    {
        parent::boot();
        static::created(function (self $section) {
            $section->slug = 'section-' . $section->id . random_int(1000, 9999);
            $section->save();
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProjectItem::class);
    }
}
