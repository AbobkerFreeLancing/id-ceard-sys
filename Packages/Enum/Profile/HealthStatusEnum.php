<?php

namespace Packages\Enum\Profile;

enum HealthStatusEnum: string
{
    case Excellent = 'excellent';
    case Good = 'good';
    case ChronicDisease = 'chronic_disease';
    case Disability = 'disability';

    public function getLabel(): string
    {
        return match ($this) {
            self::Excellent => 'ممتازة',
            self::Good => 'جيدة',
            self::ChronicDisease => 'لديه مرض مزمن',
            self::Disability => 'ذو إعاقة',
        };
    }
}
