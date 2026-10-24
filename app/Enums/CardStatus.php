<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CardStatus: string implements HasColor, HasLabel
{
    case Active = 'active';
    case Expired = 'expired';
    case Revoked = 'revoked';
    case Lost = 'lost';
    case Suspended = 'suspended';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'نشطة (Active)',
            self::Expired => 'منتهية (Expired)',
            self::Revoked => 'ملغاة (Revoked)',
            self::Lost => 'مفقودة (Lost)',
            self::Suspended => 'معلقة (Suspended)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Expired => 'warning',
            self::Revoked => 'danger',
            self::Lost => 'gray',
            self::Suspended => 'info',
        };
    }
}
