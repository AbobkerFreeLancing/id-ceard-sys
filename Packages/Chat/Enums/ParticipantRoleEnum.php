<?php

namespace Packages\Chat\Enums;

enum ParticipantRoleEnum: string
{
    case MEMBER = 'member';
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case OWNER = 'owner';

    public function label(): string
    {
        return match ($this) {
            self::MEMBER => 'Member',
            self::ADMIN => 'Admin',
            self::MODERATOR => 'Moderator',
            self::OWNER => 'Owner',
        };
    }

    public function canManageParticipants(): bool
    {
        return match ($this) {
            self::ADMIN, self::OWNER => true,
            default => false,
        };
    }

    public function canDeleteMessages(): bool
    {
        return match ($this) {
            self::ADMIN, self::MODERATOR, self::OWNER => true,
            default => false,
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
