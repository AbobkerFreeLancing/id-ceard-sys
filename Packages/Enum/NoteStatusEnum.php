<?php

namespace Packages\Enum;

enum NoteStatusEnum: string
{
    case Todo = 'todo';
    case InProgress = 'in_progress';
    case Done = 'done';
    case FuturePlan = 'future_plan';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match($this) {
            self::Todo => __('backend.todo'),
            self::InProgress => __('backend.in_progress'),
            self::Done => __('backend.done'),
            self::FuturePlan => __('backend.future_plan'),
            self::Canceled => __('backend.cancelled'),
        };
    }
}