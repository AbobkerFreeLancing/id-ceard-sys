<?php

namespace Packages\Enum\Transactions;

enum TransactionDirectionEnum: string
{
    case In = 'in';
    case Out = 'out';

    public function getLabel(): string
    {
        return match ($this) {
            self::In => __('backend.transaction_in'),
            self::Out => __('backend.transaction_out'),
        };
    }
}