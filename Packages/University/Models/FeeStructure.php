<?php

namespace Packages\University\Models;

use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packages\Accounting\Models\Currency;
use Packages\Traits\HasApprovedScope;

class FeeStructure extends Model
{
    use HasApprovedScope;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'is_medical_checkup_structure' => 'boolean',
            'approved_at' => 'datetime',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(FeeStructureItem::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(level::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function acceptanceType(): BelongsTo
    {
        return $this->belongsTo(AcceptanceType::class);
    }

    public function getFeesTotalAttribute()
    {
        return $this->items()->pluck('amount')->sum();
    }

    public function getCollegeAcademicAttribute()
    {
        return 'هيكل ' . $this->college?->name . ' ' . $this->academicYear?->name;
    }
}
