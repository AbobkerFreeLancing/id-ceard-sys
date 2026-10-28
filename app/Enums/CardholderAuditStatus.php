<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CardholderAuditStatus: string implements HasColor, HasIcon, HasLabel
{
    case Draft = 'draft';
    case PendingReview = 'pending_review';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => 'مسودة أولية',
            self::PendingReview => 'بانتظار التدقيق والمراجعة',
            self::Approved => 'معتمد وجاهز للطباعة',
            self::Rejected => 'مرفوض - بحاجة لتعديل',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::PendingReview => 'warning',
            self::Approved => 'success',
            self::Rejected => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Draft => 'heroicon-m-pencil-square',
            self::PendingReview => 'heroicon-m-clock',
            self::Approved => 'heroicon-m-check-badge',
            self::Rejected => 'heroicon-m-x-circle',
        };
    }
}
