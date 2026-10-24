<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TemplateOrientation: string implements HasLabel
{
    case Landscape = 'landscape';
    case Portrait = 'portrait';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Landscape => 'أفقي (Landscape)',
            self::Portrait => 'رأسي (Portrait)',
        };
    }
}
