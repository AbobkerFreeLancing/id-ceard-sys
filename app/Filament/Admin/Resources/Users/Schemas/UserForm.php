<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('اسم المستخدم')
                    ->required(),
                TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required(),
                Select::make('roles')
                    ->label('الأدوار والصلاحيات الوظيفية')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->label('تاريخ تأكيد البريد'),
                TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
            ]);
    }
}
