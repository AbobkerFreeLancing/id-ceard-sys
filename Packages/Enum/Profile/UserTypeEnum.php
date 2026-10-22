<?php

namespace Packages\Enum\Profile;

enum UserTypeEnum: string
{
    case User = 'user';
    case Customer = 'customer';
    case Agent = 'agent';
    case Company = 'company';
    case Teacher = 'teacher';
    case Student = 'student';

    public function getLabel(): string
    {
        return match ($this) {
            self::User => __('backend.user'),
            self::Customer => __('backend.customer'),
            self::Agent => __('backend.agent'),
            self::Company => __('backend.company'),
            self::Teacher => __('backend.teacher'),
            self::Student => __('backend.student'),
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
