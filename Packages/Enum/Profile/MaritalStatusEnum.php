<?php

namespace Packages\Enum\Profile;

enum MaritalStatusEnum: string
{
    case Single = 'single';
    case Engaged = 'engaged';
    case Married = 'married';
    case Separated = 'separated';
    case Divorced = 'divorced';
    case Widowed = 'widowed';

    public function getLabel(): string
    {
        return match ($this) {
            self::Single => __('backend.single'),
            self::Married => __('backend.married'),
            self::Separated => __('backend.separated'),
            self::Divorced => __('backend.divorced'),
            self::Widowed => __('backend.widowed'),
            self::Engaged => __('backend.engaged'),
        };
    }

    public static function getOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [
                $case->value => $case->getLabel()
            ])
            ->toArray();
    }
}
