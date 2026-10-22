<?php

namespace Packages\Enum\Profile;

enum FinancialStatusEnum: string
{
    case High = 'high';
    case AboveAverage = 'above_average';
    case Average = 'average';
    case Limited = 'limited';

    public function getLabel(): string
    {
        return match ($this) {
            self::High => 'ممتازة',
            self::AboveAverage => 'جيدة',
            self::Average => 'متوسطة',
            self::Limited => 'محدودة',
        };
    }
}
