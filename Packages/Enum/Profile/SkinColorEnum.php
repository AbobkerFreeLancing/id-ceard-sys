<?php

namespace Packages\Enum\Profile;

enum SkinColorEnum: string
{
    case Fair = 'fair';
    case Wheatish = 'wheatish';
    case Brown = 'brown';
    case Dark = 'dark';

    public function label(): string
    {
        return match ($this) {
            self::Fair => 'أبيض',
            self::Wheatish => 'قمحي',
            self::Brown => 'أسمر',
            self::Dark => 'داكن',
        };
    }
}
