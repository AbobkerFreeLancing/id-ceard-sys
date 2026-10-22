<?php

namespace Packages\Enum\Accounting;

enum SafeBankTypeEnum: string
{
    case Safe = 'safe';
    case Bank = 'bank';

    public function getLabel(): string
    {
        return match ($this) {
            self::Safe => __('backend.safe_account'),
            self::Bank => __('backend.bank_account'),
        };
    }

    public static function getOptions() : array
    {
        return [
            self::Safe->value => self::Safe->getLabel(),
            self::Bank->value => self::Bank->getLabel(),
        ];
    }
}
