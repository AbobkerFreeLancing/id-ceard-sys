<?php

namespace App\Filament\Resources\Chat\Messagings;

use App\Filament\Resources\Chat\Messagings\Pages\CreateMessaging;
use App\Filament\Resources\Chat\Messagings\Pages\EditMessaging;
use App\Filament\Resources\Chat\Messagings\Pages\ListMessagings;
use App\Filament\Resources\Chat\Messagings\Pages\ViewMessaging;
use App\Filament\Resources\Chat\Messagings\Schemas\MessagingForm;
use App\Filament\Resources\Chat\Messagings\Schemas\MessagingInfolist;
use App\Filament\Resources\Chat\Messagings\Tables\MessagingsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Musonza\Chat\Models\Conversation;

class MessagingResource extends Resource
{
    protected static ?string $model = Conversation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 10;

    // public static function getNavigationGroup(): string
    // {
    //     return __('backend.nav_module');
    // }

    public static function getLabel(): ?string
    {
        return __('backend.message');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.messaging');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.messaging');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return MessagingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MessagingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MessagingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMessagings::route('/'),
            'create' => CreateMessaging::route('/create'),
            'view' => ViewMessaging::route('/{record}'),
            'edit' => EditMessaging::route('/{record}/edit'),
        ];
    }

    // public static function getRecordRouteBindingEloquentQuery(): Builder
    // {
    //     return parent::getRecordRouteBindingEloquentQuery()
    //         ->withoutGlobalScopes([
    //             SoftDeletingScope::class,
    //         ]);
    // }
}
