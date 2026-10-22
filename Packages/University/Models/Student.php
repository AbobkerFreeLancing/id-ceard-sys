<?php

namespace Packages\University\Models;

use App\Models\State;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Packages\Common\Models\Country;
use Packages\Enum\Profile\GenderEnum;
use Packages\Support\Models\Ticket;
use Packages\Support\Models\TicketReply;
use Packages\University\Enums\GuardianRelationshipEnum;
use Packages\University\Services\StudentService;

class Student extends Authenticatable implements FilamentUser, HasName, HasAvatar
{
    use HasApiTokens;
    use Notifiable;
    use StudentService;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'gender' => GenderEnum::class,
            'guardian_relationship' => GuardianRelationshipEnum::class,
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->second_name . ' ' . $this->third_name . ' ' . $this->fourth_name;
    }

    public function gethalfNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->second_name;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile_picture
            ? Storage::url($this->profile_picture)
            : asset('static/student_profile_picture.jpg');
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function medicalCheckups(): HasMany
    {
        return $this->hasMany(MedicalCheckup::class);
    }

    public function medicalCheckup(): HasOne
    {
        return $this->hasOne(medicalCheckup::class)->latestOfMany('id');
    }

    public function interviews(): HasMany
    {
        return $this->hasMany(StudentInterview::class);
    }

    public function interview(): HasOne
    {
        return $this->hasOne(StudentInterview::class)->latestOfMany('id');
    }

    public function academicRecords(): HasMany
    {
        return $this->hasMany(AcademicRecord::class);
    }

    public function academicRecord(): HasOne
    {
        return $this->hasOne(AcademicRecord::class)->latestOfMany('id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function courseRegistrations(): HasMany
    {
        return $this->hasMany(CourseRegistration::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function charges(): HasMany
    {
        return $this->hasMany(StudentCharge::class);
    }

    public function identities(): HasMany
    {
        return $this->hasMany(StudentIdentity::class);
    }

    public function universityIDCards(): HasMany
    {
        return $this->hasMany(StudentUniversityIDCard::class);
    }

    public function universityIDCard(): HasOne
    {
        return $this->hasOne(StudentUniversityIDCard::class)->latestOfMany('id');
    }

    public function tickets(): MorphMany
    {
        return $this->morphMany(Ticket::class, 'ticketable');
    }

    public function ticketReplies(): MorphMany
    {
        return $this->morphMany(TicketReply::class, 'repliable');
    }

    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture ? Storage::url($this->profile_picture) : asset('static/filament_avatar.jpg');
    }
}
