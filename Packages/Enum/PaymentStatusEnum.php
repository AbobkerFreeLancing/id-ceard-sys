<?php

namespace Packages\Enum;

enum PaymentStatusEnum: string
{
    case UNPAID = 'unpaid';
    case PENDING = 'pending';
    case PAID = 'paid';
    case PARTIALLY_PAID = 'partially_paid';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';
    case CANCELLED = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::UNPAID => __('backend.unpaid'),
            self::PAID => __('backend.is_paid'),
            self::PARTIALLY_PAID => __('backend.partially_paid'),
            self::PENDING => __('backend.pending'),
            self::FAILED => __('backend.failed_status'),
            self::REFUNDED => __('backend.refunded_status'),
            self::CANCELLED => __('backend.cancelled'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::UNPAID => 'gray',
            self::PAID => 'success',
            self::PARTIALLY_PAID => 'warning',
            self::CANCELLED => 'danger',
        };
    }
}
