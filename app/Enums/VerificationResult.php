<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum VerificationResult: string implements HasColor, HasLabel
{
    case Valid = 'valid';
    case Expired = 'expired';
    case Revoked = 'revoked';
    case Unknown = 'unknown';
    case InvalidSignature = 'invalid_signature';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Valid => 'صالحة ومطابقة (Valid)',
            self::Expired => 'منتهية الصلاحية (Expired)',
            self::Revoked => 'ملغاة أو مسحوبة (Revoked)',
            self::Unknown => 'غير معروفة / مزورة (Unknown)',
            self::InvalidSignature => 'توقيع أمني غير صالح (Invalid Signature)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Valid => 'success',
            self::Expired => 'warning',
            self::Revoked => 'danger',
            self::Unknown => 'danger',
            self::InvalidSignature => 'danger',
        };
    }
}
