<?php

namespace Packages\Enum\Profile;

enum SmokingStatusEnum: string
{
    case NonSmoker = 'non_smoker';
    case Smoker = 'smoker';
    case Occasionally = 'occasionally';

    public function getLabel(): string
    {
        return match ($this) {
            self::NonSmoker => 'غير مدخن',
            self::Smoker => 'مدخن',
            self::Occasionally => 'يدخن أحيانًا',
        };
    }
}
