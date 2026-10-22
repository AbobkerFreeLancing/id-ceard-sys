<?php

namespace Packages\Enum\Profile;

enum WorkFieldEnum: string
{
    case Medical = 'medical';
    case Engineering = 'engineering';
    case Education = 'education';
    case Business = 'business';
    case Islamic = 'islamic';
    case Government = 'government';
    case NotWorking = 'not_working';
    case DoesNotMatter = 'does_not_matter';

    public function getLabel(): string
    {
        return match ($this) {
            self::Medical => 'طب',
            self::Engineering => 'هندسة',
            self::Education => 'تعليم',
            self::Business => 'أعمال',
            self::Islamic => 'شرعي',
            self::Government => 'حكومي',
            self::NotWorking => 'لا يعمل',
            self::DoesNotMatter => 'لا يهم',
        };
    }
}
