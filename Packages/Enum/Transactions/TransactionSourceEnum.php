<?php

namespace Packages\Enum\Transactions;

enum TransactionSourceEnum: string
{
    case Wallet = 'wallet';
    case PaymentGateway = 'payment_gateway';
    case System = 'system';

    public function label(): string
    {
        return match ($this) {
            self::Wallet => __('backend.wallet'),
        };
    }
}
