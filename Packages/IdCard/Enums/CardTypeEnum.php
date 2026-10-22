<?php

namespace Packages\IdCard\Enums;

enum CardTypeEnum: string
{
    case Student = 'student';
    case Employee = 'employee';
    case Visitor = 'visitor';
    case Member = 'member';
    case Contractor = 'contractor';
    case Event = 'event';

    public function label(): string
    {
        return match ($this) {
            self::Student => __('idcard::idcard.type_student'),
            self::Employee => __('idcard::idcard.type_employee'),
            self::Visitor => __('idcard::idcard.type_visitor'),
            self::Member => __('idcard::idcard.type_member'),
            self::Contractor => __('idcard::idcard.type_contractor'),
            self::Event => __('idcard::idcard.type_event'),
        };
    }
}
