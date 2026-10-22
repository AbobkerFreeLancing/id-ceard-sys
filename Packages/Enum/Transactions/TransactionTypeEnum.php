<?php

namespace Packages\Enum\Transactions;

enum TransactionTypeEnum: string
{
    case Withdraw = 'withdraw';
    case Deposit = 'deposit';
    case Hold = 'hold';
    case Release = 'release';

    public function getLabel(): string
    {
        return match ($this) {
            self::Withdraw => __('backend.withdraw'),
            self::Deposit => __('backend.deposit'),
            self::Hold => __('backend.money_hold'),
            self::Release => __('backend.money_release'),
        };
    }
}
