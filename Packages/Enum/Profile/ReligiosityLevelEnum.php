<?php

namespace Packages\Enum\Profile;

enum ReligiosityLevelEnum: string
{
    case VeryReligious = 'very_religious';
    case Religious = 'religious';
    case Moderate = 'moderate';
    case NotReligious = 'not_religious';

    public function getLabel(): string
    {
        return match ($this) {
            self::VeryReligious => 'ملتزم جدًا',
            self::Religious => 'ملتزم',
            self::Moderate => 'متوسط',
            self::NotReligious => 'غير ملتزم',
        };
    }
}
