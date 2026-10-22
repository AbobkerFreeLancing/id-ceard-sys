<?php

namespace Packages\Chat\Services;

use Packages\Chat\Models\Conversation;
use Packages\Chat\Models\Participant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ParticipantService
{
    /**
     * Add a participant to a conversation.
     */
    public function add(Conversation $conversation, Model $user, string $role = 'member'): Participant
    {
        return Participant::firstOrCreate(
            [
                'conversation_id' => $conversation->id,
                'user_id' => $user->id,
            ],
            [
                'role' => $role,
                'joined_at' => now(),
            ],
        );
    }

    /**
     * Remove a participant from a conversation.
     */
    public function remove(Conversation $conversation, Model $user): bool
    {
        return (bool) Participant::where([
            'conversation_id' => $conversation->id,
            'user_id' => $user->id,
        ])->delete();
    }

    /**
     * Update participant role.
     */
    public function updateRole(Participant $participant, string $role): Participant
    {
        $participant->update(['role' => $role]);
        return $participant->fresh();
    }

    /**
     * Mute/unmute a conversation for a participant.
     */
    public function toggleMute(Conversation $conversation, Model $user): bool
    {
        $participant = $this->getParticipant($conversation, $user);
        $participant->update(['is_muted' => !$participant->is_muted]);
        return $participant->fresh()->is_muted;
    }

    /**
     * Pin/unpin a conversation for a participant.
     */
    public function togglePin(Conversation $conversation, Model $user): bool
    {
        $participant = $this->getParticipant($conversation, $user);
        $participant->update(['is_pinned' => !$participant->is_pinned]);
        return $participant->fresh()->is_pinned;
    }

    /**
     * Block a participant (admin action).
     */
    public function block(Participant $participant): Participant
    {
        $participant->update(['is_blocked' => true]);
        return $participant->fresh();
    }

    /**
     * Unblock a participant.
     */
    public function unblock(Participant $participant): Participant
    {
        $participant->update(['is_blocked' => false]);
        return $participant->fresh();
    }

    /**
     * Update participant settings.
     */
    public function updateSettings(Conversation $conversation, Model $user, array $settings): Participant
    {
        $participant = $this->getParticipant($conversation, $user);
        $participant->update(['settings' => $settings]);
        return $participant->fresh();
    }

    /**
     * Mark participant as having left the conversation.
     */
    public function leave(Conversation $conversation, Model $user): bool
    {
        return (bool) Participant::where([
            'conversation_id' => $conversation->id,
            'user_id' => $user->id,
        ])->update([
            'left_at' => now(),
        ]);
    }

    /**
     * Get all participants for a conversation.
     */
    public function getParticipants(Conversation $conversation): Collection
    {
        return $conversation->participants()->with('user')->get();
    }

    /**
     * Get a single participant record.
     */
    public function getParticipant(Conversation $conversation, Model $user): ?Participant
    {
        return Participant::where([
            'conversation_id' => $conversation->id,
            'user_id' => $user->id,
        ])->first();
    }

    /**
     * Get active (non-blocked) participants.
     */
    public function getActiveParticipants(Conversation $conversation): Collection
    {
        return $conversation->participants()->with('user')->where('is_blocked', false)->get();
    }
}
