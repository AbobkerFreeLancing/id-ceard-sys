<?php

namespace Packages\Enum;

use Filament\Support\Contracts\HasColor;

enum CalculationTypeEnum: string implements HasColor
{
    case Fixed = 'fixed';
    case Percentage = 'percentage';

    public function getLabel(): string
    {
        return match ($this) {
            self::Fixed => __('backend.fixed_calc'),
            self::Percentage => __('backend.percentage'),
        };
    }

    public static function options(): array
    {
        return [
            self::Fixed->value => self::Fixed->getLabel(),
            self::Percentage->value => self::Percentage->getLabel(),
        ];
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Fixed => 'gray',
            self::Percentage => 'warning',
        };
    }
}
