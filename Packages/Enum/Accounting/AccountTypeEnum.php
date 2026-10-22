<?php

namespace Packages\Enum\Accounting;

enum AccountTypeEnum: string
{
    case Assets = 'assets';
    case Liabilities = 'liabilities';
    case Equity = 'equity';
    case Revenues = 'revenues';
    case Expenses = 'expenses';

    public function label(): string
    {
        return match ($this) {
            self::Assets => __('backend.assets'),
            self::Liabilities => __('backend.liabilities'),
            self::Equity => __('backend.equity'),
            self::Revenues => __('backend.revenues'),
            self::Expenses => __('backend.expenses'),
        };
    }
}