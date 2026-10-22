<?php

namespace Packages\Enum\Profile;

enum ChildrenCountEnum: string
{
    case None = 'none';
    case One = 'one';
    case Two = 'two';
    case Three = 'three';
    case FourOrMore = 'four_or_more';

    public function getLabel(): string
    {
        return match ($this) {
            self::None => 'لا يوجد',
            self::One => 'طفل واحد',
            self::Two => 'طفلان',
            self::Three => '3 أطفال',
            self::FourOrMore => '4 فأكثر',
        };
    }
}
