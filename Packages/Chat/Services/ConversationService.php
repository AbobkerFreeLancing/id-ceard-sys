<?php

namespace Packages\Chat\Services;

use Packages\Chat\Enums\ConversationTypeEnum;
use Packages\Chat\Models\Conversation;
use Packages\Chat\Models\Participant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ConversationService
{
    public function __construct(protected ParticipantService $participantService) {}

    public function create(
        Model $creator,
        array $participants = [],
        ConversationTypeEnum $type = ConversationTypeEnum::PRIVATE,
        ?string $name = null,
    ): Conversation {
        return match ($type) {
            ConversationTypeEnum::PRIVATE => $this->createPrivate($creator, $participants[0] ?? null),
            ConversationTypeEnum::GROUP => $this->createGroup($creator, $name ?? 'New Group', $participants),
            ConversationTypeEnum::CHANNEL => $this->createChannel($creator, $name ?? 'New Channel', $participants),
        };
    }

    public function createPrivate(Model $user, Model $recipient): Conversation
    {
        if ($user->id === $recipient->id) {
            throw ValidationException::withMessages([
                'recipient' => 'Cannot create conversation with yourself.',
            ]);
        }

        $existing = Conversation::where('type', ConversationTypeEnum::PRIVATE)
            ->whereHas('participants', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereHas('participants', function ($query) use ($recipient) {
                $query->where('user_id', $recipient->id);
            })
            ->first();

        if ($existing) {
            return $existing->load('participants');
        }

        return DB::transaction(function () use ($user, $recipient) {
            $conversation = Conversation::create([
                'type' => ConversationTypeEnum::PRIVATE,
                'created_by' => $user->id,
            ]);

            $this->participantService->add($conversation, $user, 'admin');
            $this->participantService->add($conversation, $recipient);

            return $conversation->load('participants');
        });
    }

    /**
     * Create group conversation.
     */
    public function createGroup(Model $creator, string $name, array $users = []): Conversation
    {
        return DB::transaction(function () use ($creator, $name, $users) {
            $conversation = Conversation::create([
                'type' => ConversationTypeEnum::GROUP,
                'name' => $name,
                'created_by' => $creator->id,
            ]);

            $this->participantService->add($conversation, $creator, 'admin');

            foreach ($users as $user) {
                $this->participantService->add($conversation, $user);
            }

            return $conversation->load('participants');
        });
    }

    /**
     * Create channel conversation.
     */
    public function createChannel(Model $creator, string $name, array $users = []): Conversation
    {
        return DB::transaction(function () use ($creator, $name, $users) {
            $conversation = Conversation::create([
                'type' => ConversationTypeEnum::CHANNEL,
                'name' => $name,
                'created_by' => $creator->id,
            ]);

            $this->participantService->add($conversation, $creator, 'owner');

            foreach ($users as $user) {
                $this->participantService->add($conversation, $user);
            }

            return $conversation->load('participants');
        });
    }

    /**
     * Update conversation details.
     */
    public function update(Conversation $conversation, array $data): Conversation
    {
        $conversation->update($data);
        return $conversation->fresh();
    }

    /**
     * Archive or unarchive a conversation.
     */
    public function archive(Conversation $conversation, bool $archived = true): Conversation
    {
        $conversation->update(['is_archived' => $archived]);
        return $conversation->fresh();
    }

    /**
     * Lock or unlock a conversation.
     */
    public function lock(Conversation $conversation, bool $locked = true): Conversation
    {
        $conversation->update(['is_locked' => $locked]);
        return $conversation->fresh();
    }

    /**
     * Add user to conversation.
     */
    public function addParticipant(Conversation $conversation, Model $user, string $role = 'member'): Participant
    {
        return $this->participantService->add($conversation, $user, $role);
    }

    /**
     * Remove user from conversation.
     */
    public function removeParticipant(Conversation $conversation, Model $user): bool
    {
        return $this->participantService->remove($conversation, $user);
    }

    /**
     * Get user conversations.
     */
    public function userConversations(Model $user): Collection
    {
        return Conversation::whereHas('participants', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with(['participants.user', 'lastMessage'])
            ->latest()
            ->get();
    }

    /**
     * Check user membership.
     */
    public function hasParticipant(Conversation $conversation, Model $user): bool
    {
        return $this->participantService->getParticipant($conversation, $user) !== null;
    }

    /**
     * Get participants count.
     */
    public function participantsCount(Conversation $conversation): int
    {
        return $conversation->participants()->count();
    }

    /**
     * Soft-delete a conversation.
     */
    public function delete(Conversation $conversation): bool
    {
        return $conversation->delete();
    }
}
