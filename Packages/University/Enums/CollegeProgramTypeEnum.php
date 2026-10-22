<?php

namespace Packages\University\Enums;

enum CollegeProgramTypeEnum: string
{
    case Bachelor = 'bachelor';
    case Diploma = 'diploma';
    case Continuing = 'continuing';
    case Postgraduate = 'postgraduate';

    public function getLabel(): string
    {
        return match ($this) {
            self::Bachelor => __('backend.bachelor_degree'),
            self::Diploma => __('backend.diploma'),
            self::Continuing => __('backend.continuing_degree'),
            self::Postgraduate => __('backend.postgraduate'),
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
