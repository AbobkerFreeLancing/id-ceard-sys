<?php

namespace Packages\University\Enums;

enum IdentityTypeEnum: string
{
    case NationalId = 'national_id';
    case Passport = 'passport';
    case StudentCard = 'student_card';
    case BirthCertificate = 'birth_certificate';
    case DrivingLicense = 'driving_license';
    case SecondaryCertificate = 'secondary_certificate';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::NationalId => 'مستند إثبات شخصية (الرقم الوطني)',
            self::SecondaryCertificate => 'مستند الشهادة السودانية (الثانوية)',
            self::Passport => 'جواز السفر',
            self::BirthCertificate => 'شهادة الميلاد',
            self::StudentCard => 'البطاقة الطلابية',
            self::DrivingLicense => 'رخصة القيادة',
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
