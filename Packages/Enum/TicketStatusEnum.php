<?php

namespace Packages\Enum;

enum TicketStatusEnum: string
{
    case Open = 'open';
    case InProgress = 'in_progress';
    case Closed = 'closed';

    public function label(): string
    {
        return match($this) {
            self::Open => __('backend.status_open'),
            self::InProgress => __('backend.in_progress'),
            self::Closed => __('backend.closed'),
        };
    }

    public static function options(): array
    {
        return [
            self::Open->value => self::Open->label(),
            self::InProgress->value => self::InProgress->label(),
            self::Closed->value => self::Closed->label(),
        ];
    }
}