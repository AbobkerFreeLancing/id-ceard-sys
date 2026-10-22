<?php

namespace App\Models;

use App\Observers\UserObserver;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Packages\Accounting\Models\Account;
use Packages\Accounting\Models\UserPayment;
use Packages\Chat\Traits\HasChat;
use Packages\Common\Models\Branch;
use Packages\Common\Models\Customer;
use Packages\Common\Models\Note;
use Packages\Common\Models\Profile;
use Packages\Payroll\Models\Payroll;
use Packages\Support\Models\Ticket;
use Packages\Support\Models\TicketReply;
use Packages\Wallet\Models\Wallet;
use Spatie\Activitylog\Models\Concerns\CausesActivity;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements FilamentUser, HasName, HasAvatar, HasTenants, HasDefaultTenant
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use HasChat;
    use CausesActivity;

    public function getParticipantDetailsAttribute()
    {
        return [
            'name' => $this->name,
        ];
    }

    protected $guarded = [];

    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['fullname'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'has_admin_sidebar' => 'boolean',
            'profile_completed' => 'boolean',
        ];
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class)->where('branches.is_enabled', true);
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->branches;
    }

    public function getDefaultTenant(Panel $panel): ?Model
    {
        return $this->branches()->first();
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->branches->contains($tenant);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return asset('static/filament_avatar.jpg');
    }

    public function getPictureUrlAttribute()
    {
        return $this->profile_picture ? Storage::url($this->profile_picture) : asset('static/filament_avatar.jpg');
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function isBanned(): bool
    {
        return $this->banned_at !== null;
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(UserPayment::class);
    }

    public function tickets(): MorphMany
    {
        return $this->morphMany(Ticket::class, 'ticketable');
    }

    public function ticketReplies(): MorphMany
    {
        return $this->morphMany(TicketReply::class, 'repliable');
    }

    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }
}
