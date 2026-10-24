<?php

namespace App\Models;

use App\Enums\CardStatus;
use Database\Factories\CardholderFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cardholder extends Model
{
    /** @use HasFactory<CardholderFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'idcard_cardholders';

    protected $guarded = ['id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'extra_data' => 'array',
        ];
    }

    /**
     * Scope a query to search cardholders by name, national ID, or employee number.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('full_name_ar', 'like', "%{$search}%")
                ->orWhere('full_name_en', 'like', "%{$search}%")
                ->orWhere('national_id', 'like', "%{$search}%")
                ->orWhere('employee_no', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to find a cardholder by national ID.
     */
    public function scopeByNationalId(Builder $query, string $nationalId): Builder
    {
        return $query->where('national_id', $nationalId);
    }

    /**
     * Scope a query to only include cardholders belonging to a specific organization.
     */
    public function scopeForOrganization(Builder $query, int $organizationId): Builder
    {
        return $query->where('organization_id', $organizationId);
    }

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
        return $this->hasOne(Card::class, 'cardholder_id')->where('status', CardStatus::Active->value);
    }
}
