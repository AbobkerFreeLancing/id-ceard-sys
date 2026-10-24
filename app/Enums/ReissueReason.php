<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ReissueReason: string implements HasLabel
{
    case Lost = 'lost';
    case Damaged = 'damaged';
    case Stolen = 'stolen';
    case DataChange = 'data_change';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Lost => 'مفقودة (Lost)',
            self::Damaged => 'تالفة (Damaged)',
            self::Stolen => 'مسروقة (Stolen)',
            self::DataChange => 'تعديل بيانات (Data Change)',
        };
    }
}
