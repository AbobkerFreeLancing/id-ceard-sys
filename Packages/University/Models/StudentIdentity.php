<?php

namespace Packages\University\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Packages\University\Enums\IdentityTypeEnum;

class StudentIdentity extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'type' => IdentityTypeEnum::class,
            'issue_date' => 'date',
            'expiry_date' => 'date',
            'is_approved' => 'boolean',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
