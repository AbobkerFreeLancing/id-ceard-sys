<?php

namespace Packages\Chat\Traits;

use Packages\Chat\Enums\MessageTypeEnum;
use Packages\Chat\Models\Conversation;
use Packages\Chat\Models\Message;
use Packages\Chat\Models\Participant;
use Packages\Chat\Services\ConversationService;
use Packages\Chat\Services\MessageService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $avatar_url
 * @property string|null $profile_photo_url
 */
trait HasChat
{
    /**
     * Get all participant records for this user.
     */
    public function chatParticipants(): HasMany
    {
        return $this->hasMany(Participant::class, 'user_id');
    }

    /**
     * Get all conversations this user is a participant in.
     */
    public function conversations(): Collection
    {
        return app(ConversationService::class)->userConversations($this);
    }

    /**
     * Get all conversations (as a relationship query).
     */
    public function chatConversations(): HasManyThrough
    {
        return $this->hasManyThrough(
            Conversation::class,
            Participant::class,
            'user_id', // Foreign key on participants table
            'id', // Foreign key on conversations table
            localKey: 'id',
            secondLocalKey: 'conversation_id',
        );
    }

    /**
     * Check if this user is a participant in a given conversation.
     */
    public function isInConversation(Conversation $conversation): bool
    {
        return app(ConversationService::class)->hasParticipant($conversation, $this);
    }

    /**
     * Create a private conversation with another user.
     */
    public function createConversationWith($recipient): Conversation
    {
        return app(ConversationService::class)->createPrivate($this, $recipient);
    }

    /**
     * Create a group conversation.
     */
    public function createGroup(string $name, array $participants = []): Conversation
    {
        return app(ConversationService::class)->createGroup($this, $name, $participants);
    }

    /**
     * Send a message to a conversation.
     */
    public function sendMessage(
        Conversation $conversation,
        string $body,
        array $options = [],
    ): \Packages\Chat\Models\Message {
        return app(MessageService::class)->send(
            conversation: $conversation,
            sender: $this,
            body: $body,
            type: $options['type'] ?? \Packages\Chat\Enums\MessageTypeEnum::TEXT,
            replyTo: $options['replyTo'] ?? null,
            attachments: $options['attachments'] ?? [],
            meta: $options['meta'] ?? [],
        );
    }

    /**
     * Get the participant details for chat display.
     * Override this in your User model to customize.
     */
    public function getParticipantDetailsAttribute(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email ?? null,
            'avatar' => $this->avatar_url ?? ($this->profile_photo_url ?? null),
        ];
    }

    /**
     * Get unread message count across all conversations.
     */
    public function getUnreadCountAttribute(): int
    {
        return Participant::where('user_id', $this->id)
            ->where(function ($query) {
                $query->whereNull('last_read_at')->orWhereColumn('last_read_at', '<', function ($q) {
                    $q->select('created_at')
                        ->from('chat_messages')
                        ->whereColumn('conversation_id', 'chat_participants.conversation_id')
                        ->latest()
                        ->limit(1);
                });
            })
            ->count();
    }
}
