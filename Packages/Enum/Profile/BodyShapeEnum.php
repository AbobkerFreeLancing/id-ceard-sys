<?php

namespace Packages\Enum\Profile;

enum BodyShapeEnum: string
{
    case SLIM = 'slim';
    case AVERAGE = 'average';
    case ATHLETIC = 'athletic';
    case MUSCULAR = 'muscular';
    case OVERWEIGHT = 'overweight';
    case HEAVY = 'heavy';

    public function getLabel(): string
    {
        return match ($this) {
            self::SLIM => __('backend.slim'),
            self::AVERAGE => __('backend.average'),
            self::ATHLETIC => __('backend.athletic'),
            self::MUSCULAR => __('backend.muscular'),
            self::OVERWEIGHT => __('backend.overweight'),
            self::HEAVY => __('backend.heavy'),
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
