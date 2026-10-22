<?php

namespace Packages\Enum;

enum BloodGroupEnum: string
{
    case A_POSITIVE = 'A+';
    case A_NEGATIVE = 'A-';
    case AB_POSITIVE = 'AB+';
    case AB_NEGATIVE = 'AB-';
    case B_POSITIVE = 'B+';
    case B_NEGATIVE = 'B-';
    case O_POSITIVE = 'O+';
    case O_NEGATIVE = 'O-';

    public static function options(): array
    {
        return [
            self::A_POSITIVE->value => self::A_POSITIVE->value,
            self::A_NEGATIVE->value => self::A_NEGATIVE->value,
            self::AB_POSITIVE->value => self::AB_POSITIVE->value,
            self::AB_NEGATIVE->value => self::AB_NEGATIVE->value,
            self::B_POSITIVE->value => self::B_POSITIVE->value,
            self::B_NEGATIVE->value => self::B_NEGATIVE->value,
            self::O_POSITIVE->value => self::O_POSITIVE->value,
            self::O_NEGATIVE->value => self::O_NEGATIVE->value,
        ];
    }
    
}
