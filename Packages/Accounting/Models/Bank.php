<?php

namespace Packages\Accounting\Models;

use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packages\Traits\HasActiveScope;

class Bank extends Model
{
    use HasFactory;
    use HasEnabledScope;
    use HasActiveScope;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'int',
        ];
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }
}
