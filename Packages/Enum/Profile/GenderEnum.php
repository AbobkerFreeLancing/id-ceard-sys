<?php

namespace Packages\Enum\Profile;

enum GenderEnum: string
{
    case Male = 'male';
    case Female = 'female';

    public function label(): string
    {
        return match ($this) {
            self::Male => __('backend.male'),
            self::Female => __('backend.female'),
        };
    }

    public static function getOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(
                fn($case) => [
                    $case->value => $case->label(),
                ],
            )
            ->toArray();
    }
}
