<?php

namespace Packages\Enum\Profile;

enum HijabEnum: string
{
    case Niqab = 'niqab';
    case Hijab = 'hijab';
    case DoesNotMatter = 'does_not_matter';

    public function label(): string
    {
        return match ($this) {
            self::Niqab => 'منقبة',
            self::Hijab => 'محجبة',
            self::DoesNotMatter => 'لا يهم',
        };
    }
}
