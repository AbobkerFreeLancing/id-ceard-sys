<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packages\Traits\HasActiveScope;

class ResultType extends Model
{
    use HasActiveScope;
    
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean'
        ];
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
