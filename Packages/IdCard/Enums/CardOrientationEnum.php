<?php

namespace Packages\IdCard\Enums;

enum CardOrientationEnum: string
{
    case Landscape = 'landscape';
    case Portrait = 'portrait';

    public function label(): string
    {
        return match ($this) {
            self::Landscape => __('idcard::idcard.orientation_landscape'),
            self::Portrait => __('idcard::idcard.orientation_portrait'),
        };
    }
}
