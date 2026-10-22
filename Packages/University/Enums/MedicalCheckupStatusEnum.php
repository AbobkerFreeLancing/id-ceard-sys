<?php

namespace Packages\University\Enums;

enum MedicalCheckupStatusEnum: string
{
    case Pending = 'pending';
    case Fit = 'fit';
    case UnFit = 'unfit';
    case UnderReview = 'under_review';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => __('backend.pending'),
            self::Fit => __('backend.fit'),
            self::UnFit => __('backend.unfit'),
            self::UnderReview => __('backend.under_review'),
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
