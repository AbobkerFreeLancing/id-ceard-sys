<?php

namespace Packages\Common\Models;

use App\Models\User;
use Packages\Enum\NoteStatusEnum;
use Packages\Enum\PriorityEnum;
use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;
    use HasEnabledScope;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            PriorityEnum::Low->value => __('backend.priority_low'),
            PriorityEnum::Medium->value => __('backend.priority_medium'),
            PriorityEnum::High->value => __('backend.priority_high'),
            PriorityEnum::Urgent->value => __('backend.priority_urgent'),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            NoteStatusEnum::Todo->value => __('backend.todo'),
            NoteStatusEnum::InProgress->value => __('backend.in_progress'),
            NoteStatusEnum::Done->value => __('backend.done'),
            NoteStatusEnum::Canceled->value => __('backend.cancelled'),
            NoteStatusEnum::FuturePlan->value => __('backend.future_plan'),
        };
    }
}
