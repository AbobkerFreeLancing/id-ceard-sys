<?php

namespace Packages\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketReply extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_internal_note' => 'boolean',
        ];
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function repliable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getSenderNameAttribute(): string
    {
        if ($this->repliable instanceof \Packages\University\Models\Student) {
            return $this->repliable->name . ' (طالب)';
        }
        if ($this->repliable instanceof \App\Models\User) {
            return $this->repliable->name . ' (الدعم الفني)';
        }
        return 'مستخدم';
    }

    public function getIsSupportStaffAttribute(): bool
    {
        return $this->repliable instanceof \App\Models\User;
    }
}
