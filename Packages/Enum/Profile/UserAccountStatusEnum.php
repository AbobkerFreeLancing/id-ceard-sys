<?php

namespace Packages\Enum\Profile;

enum UserAccountStatusEnum: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Banned = 'banned';


    public function getLabel(): string
    {
        return match ($this) {
            self::Active => __('backend.active'),
            self::Inactive => __('backend.inactive'),
            self::Banned => __('backend.banned'),
        };
    }

    public static function getOptions(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->getLabel()
        ])->toArray();
    }

    public static function getOptionsExcept(string $excluded): array
    {
        return collect(self::cases())
            ->reject(fn(self $case) => $case->value === $excluded)
            ->mapWithKeys(fn(self $case) => [
                $case->value => $case->getLabel(),
            ])
            ->toArray();
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'gray',
            self::Banned => 'danger',
        };
    }
}
