<?php

namespace Packages\Chat\Enums;

enum ConversationTypeEnum: string
{
    case PRIVATE = 'private';

    case GROUP = 'group';

    case CHANNEL = 'channel';

    public function label(): string
    {
        return match ($this) {
            self::PRIVATE => 'Private',
            self::GROUP => 'Group',
            self::CHANNEL => 'Channel',
        };
    }

    public function isPrivate(): bool
    {
        return $this === self::PRIVATE;
    }

    public function isGroup(): bool
    {
        return $this === self::GROUP;
    }

    public function isChannel(): bool
    {
        return $this === self::CHANNEL;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(
                fn(self $case) => [
                    $case->value => $case->label(),
                ],
            )
            ->all();
    }
}
