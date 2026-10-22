<?php

namespace Packages\IdCard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $table = 'idcard_organizations';

    protected $fillable = [
        'name',
        'code',
        'logo_path',
        'website',
        'contact_email',
        'contact_phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'organization_id');
    }

    public function cardholders(): HasMany
    {
        return $this->hasMany(Cardholder::class, 'organization_id');
    }

    public function templates(): HasMany
    {
        return $this->hasMany(CardTemplate::class, 'organization_id');
    }
}
