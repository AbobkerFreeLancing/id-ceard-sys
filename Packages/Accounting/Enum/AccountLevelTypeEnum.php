<?php

namespace Packages\Accounting\Enum;

enum AccountLevelTypeEnum: string
{
    case Group = 'group';
    case Sub = 'sub';

    public function getLabel(): string
    {
        return match ($this) {
            self::Group => __('backend.group'),
            self::Sub => __('backend.sub'),
        };
    }

    public static function getOptions(): array
    {
        return [
            self::Group->value => self::Group->getLabel(),
            self::Sub->value => self::Sub->getLabel(),
        ];
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Group => 'success',
            self::Sub => 'warning',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Group => 'heroicon-o-folder-open',
            self::Sub => 'heroicon-o-document-text',
        };
    }
}
