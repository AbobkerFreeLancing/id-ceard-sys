<?php

namespace Packages\University\Enums;

enum PaymentShortStatusEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => __('backend.pending'),
            self::APPROVED => __('backend.approved'),
            self::REJECTED => __('backend.rejected'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
        };
    }
}
