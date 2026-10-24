<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BatchStatus: string implements HasColor, HasLabel
{
    case Draft = 'draft';
    case Generating = 'generating';
    case Ready = 'ready';
    case Printed = 'printed';
    case Failed = 'failed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => 'مسودة (Draft)',
            self::Generating => 'قيد التوليد (Generating)',
            self::Ready => 'جاهزة للطباعة (Ready)',
            self::Printed => 'تمت الطباعة (Printed)',
            self::Failed => 'فشلت (Failed)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Generating => 'info',
            self::Ready => 'warning',
            self::Printed => 'success',
            self::Failed => 'danger',
        };
    }
}
