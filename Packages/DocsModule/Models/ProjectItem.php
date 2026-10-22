<?php

namespace Packages\DocsModule\Models;

use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectItem extends Model
{
    use HasEnabledScope;

    protected $table = "docs_project_items";

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
        static::created(function (self $item) {
            $item->slug = 'item-' . $item->id . random_int(1000, 9999);
            $item->save();
        });
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
