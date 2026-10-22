<?php

namespace Packages\Chat\Services;

use Packages\Chat\Enums\MessageTypeEnum;
use Packages\Chat\Events\MessageSentEvent;
use Packages\Chat\Models\Conversation;
use Packages\Chat\Models\Message;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MessageService
{
    public function __construct(protected AttachmentService $attachmentService) {}

    /**
     * Send a message to a conversation.
     */
    public function send(
        Conversation $conversation,
        Model $sender,
        string $body,
        MessageTypeEnum $type = MessageTypeEnum::TEXT,
        ?Message $replyTo = null,
        array $attachments = [],
        array $meta = [],
    ): Message {
        // Check if conversation is locked
        if ($conversation->is_locked) {
            throw new \RuntimeException('Conversation is locked.');
        }

        // Check if sender is a participant
        if (!$conversation->participants()->where('user_id', $sender->id)->exists()) {
            throw new \RuntimeException('Sender is not a participant in this conversation.');
        }

        return DB::transaction(function () use ($conversation, $sender, $body, $type, $replyTo, $attachments, $meta) {
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $sender->id,
                'reply_to_id' => $replyTo?->id,
                'type' => $type,
                'body' => $body,
                'meta' => $meta,
            ]);

            // Attach files if any
            if (!empty($attachments)) {
                $this->attachmentService->attach($message, $attachments);
            }

            // Update conversation's last message
            $conversation->update(['last_message_id' => $message->id]);

            // Broadcast event
            broadcast(new MessageSentEvent($message))->toOthers();

            return $message->load(['sender', 'attachments', 'replyTo']);
        });
    }

    /**
     * Edit a message.
     */
    public function update(Message $message, Model $user, string $newBody): Message
    {
        if ($message->user_id !== $user->id) {
            throw new \RuntimeException('You can only edit your own messages.');
        }

        $message->update([
            'body' => $newBody,
            'edited_at' => now(),
        ]);

        return $message->fresh();
    }

    /**
     * Soft-delete a message.
     */
    public function delete(Message $message, Model $user): bool
    {
        // Allow message author or conversation admin/owner to delete
        $isAdmin = $message->conversation
            ->participants()
            ->where('user_id', $user->id)
            ->whereIn('role', ['admin', 'owner'])
            ->exists();

        if ($message->user_id !== $user->id && !$isAdmin) {
            throw new \RuntimeException('Unauthorized to delete this message.');
        }

        return $message->delete();
    }

    /**
     * Get messages for a conversation (paginated).
     */
    public function getMessages(
        Conversation $conversation,
        int $perPage = 50,
        ?int $beforeId = null,
    ): LengthAwarePaginator {
        $query = $conversation
            ->messages()
            ->with(['sender', 'attachments', 'replyTo'])
            ->latest();

        if ($beforeId) {
            $query->where('id', '<', $beforeId);
        }

        return $query->paginate($perPage);
    }

    /**
     * Mark message as read by a participant.
     */
    public function markAsRead(Conversation $conversation, Model $user, Message $message): void
    {
        $conversation
            ->participants()
            ->where('user_id', $user->id)
            ->update([
                'last_read_at' => now(),
                'last_read_message_id' => $message->id,
            ]);
    }

    /**
     * Search messages within a conversation.
     */
    public function search(Conversation $conversation, string $query): Collection
    {
        return $conversation
            ->messages()
            ->with(['sender', 'attachments'])
            ->where('body', 'like', "%{$query}%")
            ->latest()
            ->get();
    }
}
