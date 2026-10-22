<?php

namespace Packages\Enum\Transactions;

enum TransactionStatusEnum: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Successful = 'successful';
    case Failed = 'failed';
    case Reversed = 'reversed';
    case SettlementInProgress = 'settlement_in_progress';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => __('backend.pending'),
            self::Processing => __('backend.processing'),
            self::Successful => __('backend.successful_status'),
            self::Failed => __('backend.failed_status'),
            self::Reversed => __('backend.reversed_status'),
            self::SettlementInProgress => __('backend.settlement_in_progress'),
            self::Cancelled => __('backend.cancelled'),
        };
    }
}
