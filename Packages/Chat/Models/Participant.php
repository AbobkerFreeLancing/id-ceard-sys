<?php

namespace Packages\Chat\Models;

use App\Models\User;
use Packages\Chat\Enums\ParticipantRoleEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    protected $table = 'chat_participants';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'role' => ParticipantRoleEnum::class,

            'joined_at' => 'datetime',
            'left_at' => 'datetime',
            'last_read_at' => 'datetime',
            'last_seen_at' => 'datetime',

            'settings' => 'array',

            'is_muted' => 'boolean',
            'is_pinned' => 'boolean',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lastReadMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'last_read_message_id');
    }
}
