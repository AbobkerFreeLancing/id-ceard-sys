<?php

namespace Packages\Enum\Transactions;

enum TransactionServiceTypeEnum: string
{
    case Electricity = 'electricity';
    case Water = 'water';
    case Government = 'government';
    case Internet = 'internet';
    case Mobile = 'mobile';
    case Tv = 'tv';

    public function label(): string
    {
        return match ($this) {
            self::Electricity => __('backend.electricity'),
        };
    }
}
