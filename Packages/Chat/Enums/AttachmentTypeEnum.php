<?php

namespace Packages\Chat\Enums;

enum AttachmentTypeEnum: string
{
    case IMAGE = 'image';
    case VIDEO = 'video';
    case AUDIO = 'audio';
    case FILE = 'file';
    case VOICE = 'voice';

    public function label(): string
    {
        return match ($this) {
            self::IMAGE => 'Image',
            self::VIDEO => 'Video',
            self::AUDIO => 'Audio',
            self::FILE => 'File',
            self::VOICE => 'Voice',
        };
    }

    public function isMedia(): bool
    {
        return match ($this) {
            self::IMAGE, self::VIDEO, self::AUDIO, self::VOICE => true,
            default => false,
        };
    }
}
