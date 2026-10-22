<?php

namespace Packages\Enum\Profile;

enum PrayerStatusEnum: string
{
    case Always = 'always';
    case Mostly = 'mostly';
    case Sometimes = 'sometimes';
    case Rarely = 'rarely';
    case Never = 'never';

    public function getLabel(): string
    {
        return match ($this) {
            self::Always => 'محافظ على الصلاة',
            self::Mostly => 'غالبًا',
            self::Sometimes => 'أحيانًا',
            self::Rarely => 'نادرًا',
            self::Never => 'لا يصلي',
        };
    }
}
