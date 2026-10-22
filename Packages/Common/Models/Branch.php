<?php

namespace Packages\Common\Models;

use App\Models\User;
use Packages\School\Models\Classroom;
use Packages\School\Models\Student;
use Packages\School\Models\Teacher;
use Packages\Traits\BranchHasServicesTrait;
use Packages\Traits\HasEnabledScope;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model implements HasAvatar
{
    use HasEnabledScope;
    use BranchHasServicesTrait;
    use SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'is_editable' => 'boolean',
        ];
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return asset('static/branch_switcher.png');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'branch_user');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}
