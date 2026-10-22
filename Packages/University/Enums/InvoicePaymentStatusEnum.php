<?php

namespace Packages\University\Enums;

enum InvoicePaymentStatusEnum: string
{
    case Unpaid = 'unpaid';
    case PartiallyPaid = 'partially_paid';
    case Paid = 'paid';

    public function getLabel(): string
    {
        return match ($this) {
            self::Unpaid => __('backend.unpaid'),
            self::PartiallyPaid => __('backend.partially_paid'),
            self::Paid => __('backend.paid'),
        };
    }

    public static function getOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(
                fn($case) => [
                    $case->value => $case->getLabel(),
                ],
            )
            ->toArray();
    }
}
