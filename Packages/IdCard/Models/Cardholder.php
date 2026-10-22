<?php

namespace Packages\IdCard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cardholder extends Model
{
    protected $table = 'idcard_cardholders';

    protected $fillable = [
        'organization_id',
        'department_id',
        'first_name',
        'last_name',
        'full_name_ar',
        'full_name_en',
        'national_id',
        'identifier_code',
        'email',
        'phone',
        'blood_type',
        'job_title',
        'photo_path',
        'processed_photo_path',
        'signature_path',
        'status',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'cardholder_id');
    }

    public function activeCard(): HasOne
    {
        return $this->hasOne(Card::class, 'cardholder_id')->where('status', 'active')->latestOfMany();
    }

    public function getPhotoUrlAttribute(): ?string
    {
        $path = $this->processed_photo_path ?? $this->photo_path;
        return $path ? asset('storage/' . $path) : asset('frontend/img/placeholder_avatar.png');
    }
}
