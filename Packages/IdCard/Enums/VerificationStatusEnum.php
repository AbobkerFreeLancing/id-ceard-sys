<?php

namespace Packages\IdCard\Enums;

enum VerificationStatusEnum: string
{
    case Valid = 'valid';
    case Expired = 'expired';
    case Revoked = 'revoked';
    case Suspended = 'suspended';
    case InvalidToken = 'invalid_token';

    public function label(): string
    {
        return match ($this) {
            self::Valid => __('idcard::idcard.verif_valid'),
            self::Expired => __('idcard::idcard.verif_expired'),
            self::Revoked => __('idcard::idcard.verif_revoked'),
            self::Suspended => __('idcard::idcard.verif_suspended'),
            self::InvalidToken => __('idcard::idcard.verif_invalid_token'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Valid => 'success',
            self::Expired => 'warning',
            self::Revoked, self::Suspended, self::InvalidToken => 'danger',
        };
    }
}
