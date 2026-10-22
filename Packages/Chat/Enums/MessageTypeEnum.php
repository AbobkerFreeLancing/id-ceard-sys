<?php

namespace Packages\Chat\Enums;

enum MessageTypeEnum: string
{
    case TEXT = 'text';
    case IMAGE = 'image';
    case VIDEO = 'video';
    case AUDIO = 'audio';
    case FILE = 'file';
    case LOCATION = 'location';
    case CONTACT = 'contact';
    case SYSTEM = 'system';

    public function hasAttachment(): bool
    {
        return match ($this) {
            self::IMAGE, self::VIDEO, self::AUDIO, self::FILE => true,
            default => false,
        };
    }

    public function isMedia(): bool
    {
        return match ($this) {
            self::IMAGE, self::VIDEO, self::AUDIO => true,
            default => false,
        };
    }

    public function isSystem(): bool
    {
        return $this === self::SYSTEM;
    }
}
