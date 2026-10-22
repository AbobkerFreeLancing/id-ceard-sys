<?php

namespace Packages\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;

enum AttendanceStatusEnum: string implements HasLabel, HasColor, HasIcon
{
    case NOT_TAKEN = 'not_taken';
    case PRESENT = 'present';
    case ABSENT = 'absent';
    case LATE = 'late';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NOT_TAKEN => __('backend.not_taken'),
            self::PRESENT => __('backend.present'),
            self::ABSENT => __('backend.absent'),
            self::LATE => __('backend.late'),
        };
    }

    public static function options() : array
    {
        return [
            self::NOT_TAKEN->value => self::NOT_TAKEN->getLabel(),
            self::PRESENT->value => self::PRESENT->getLabel(),
            self::ABSENT->value => self::ABSENT->getLabel(),
            self::LATE->value => self::LATE->getLabel(),
        ];
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::NOT_TAKEN => 'gray',
            self::PRESENT => 'success',
            self::ABSENT => 'danger',
            self::LATE => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::NOT_TAKEN => 'heroicon-o-home',
            self::PRESENT => 'heroicon-o-check-circle',
            self::ABSENT => 'heroicon-o-x-circle',
            self::LATE => 'heroicon-o-clock',
        };
    }
}