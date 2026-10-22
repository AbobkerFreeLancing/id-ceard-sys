<?php

namespace Packages\University\Enums;

enum GuardianRelationshipEnum: string
{
    case Father = 'father';
    case Mother = 'mother';
    case Brother = 'brother';
    case Sister = 'sister';
    case PaternalUncle = 'paternal_uncle';
    case PaternalAunt = 'paternal_aunt';
    case MaternalUncle = 'maternal_uncle';
    case MaternalAunt = 'maternal_aunt';
    case Grandfather = 'grandfather';
    case Grandmother = 'grandmother';
    case Husband = 'husband';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Father => 'الأب',
            self::Mother => 'الأم',
            self::Brother => 'الأخ',
            self::Sister => 'الأخت',
            self::PaternalUncle => 'العم',
            self::PaternalAunt => 'العمة',
            self::MaternalUncle => 'الخال',
            self::MaternalAunt => 'الخالة',
            self::Grandfather => 'الجد',
            self::Grandmother => 'الجدة',
            self::Husband => 'الزوج',
            self::Other => 'أخرى',
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
