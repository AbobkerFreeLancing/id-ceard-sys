<?php

namespace Packages\IdCard\Enums;

enum CardStatusEnum: string
{
    case Draft = 'draft';
    case PendingApproval = 'pending_approval';
    case Approved = 'approved';
    case InPrinting = 'in_printing';
    case Printed = 'printed';
    case Active = 'active';
    case Suspended = 'suspended';
    case Expired = 'expired';
    case Revoked = 'revoked';
    case Lost = 'lost';

    public function label(): string
    {
        return match ($this) {
            self::Draft => __('idcard::idcard.status_draft'),
            self::PendingApproval => __('idcard::idcard.status_pending'),
            self::Approved => __('idcard::idcard.status_approved'),
            self::InPrinting => __('idcard::idcard.status_in_printing'),
            self::Printed => __('idcard::idcard.status_printed'),
            self::Active => __('idcard::idcard.status_active'),
            self::Suspended => __('idcard::idcard.status_suspended'),
            self::Expired => __('idcard::idcard.status_expired'),
            self::Revoked => __('idcard::idcard.status_revoked'),
            self::Lost => __('idcard::idcard.status_lost'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::PendingApproval => 'warning',
            self::Approved => 'info',
            self::InPrinting => 'primary',
            self::Printed, self::Active => 'success',
            self::Suspended => 'warning',
            self::Expired, self::Revoked, self::Lost => 'danger',
        };
    }
}
