<?php

namespace Packages\Enum\Profile;

enum EducationLevelEnum: string
{
    case GeneralSecondaryEquivalent = 'secondary_education_equivalent';
    case Diploma = 'diploma';
    case BachelorDegree  = 'bachelor_degree';
    case HigherDiploma  = 'higher_diploma';
    case MastersDegree  = 'masters_degree';
    case PHD  = 'phd_degree';

    public function getLabel(): string
    {
        return match ($this) {
            self::GeneralSecondaryEquivalent => __('backend.secondary_education_equivalent'),
            self::Diploma      => __('backend.diploma'),
            self::BachelorDegree     => __('backend.bachelor_degree'),
            self::HigherDiploma     => __('backend.higher_diploma'),
            self::MastersDegree     => __('backend.masters_degree'),
            self::PHD     => __('backend.phd_degree'),
        };
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
