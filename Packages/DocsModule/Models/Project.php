<?php

namespace Packages\DocsModule\Models;

use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasEnabledScope;
    use SoftDeletes;

    protected $table = "docs_projects";

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean'
        ];
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function getNiceCreatedAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getNiceUpdatedAttribute()
    {
        return $this->updated_at->diffForHumans();
    }
}
