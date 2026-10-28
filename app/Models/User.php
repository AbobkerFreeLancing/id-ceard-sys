<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cardBatches(): HasMany
    {
        return $this->hasMany(CardBatch::class, 'created_by');
    }

    public function verificationLogs(): HasMany
    {
        return $this->hasMany(VerificationLog::class, 'scanned_by');
    }

    public function requestedReissues(): HasMany
    {
        return $this->hasMany(CardReissue::class, 'requested_by');
    }

    public function approvedReissues(): HasMany
    {
        return $this->hasMany(CardReissue::class, 'approved_by');
    }
}
