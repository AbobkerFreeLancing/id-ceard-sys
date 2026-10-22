<?php

namespace App\Filament\Resources\Accounting;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\Accounting\PaymentMethodResource\Pages\ListPaymentMethods;
use App\Filament\Resources\Accounting\PaymentMethodResource\Pages;
use App\Filament\Resources\Accounting\PaymentMethodResource\RelationManagers;
use Packages\Accounting\Models\PaymentMethod;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-hashtag';

    public static function getLabel(): ?string
    {
        return __('backend.payment_method');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.payment_methods');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.payment_methods'));
    }

    public static function getNavigationGroup(): string
    {
        return __('backend.settings');
    }

    public static function shouldRegisterNavigation(): bool
    {
        // return auth()->user()->can('payment_methods_list');
        return false;
    }

    public static function canCreate(): bool
    {
        // return auth()->user()->can('payment_methods_create');
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('payment_methods_update') && $record->is_editable;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('payment_methods_delete') && $record->is_editable;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([TextInput::make('name')->label(__('backend.name'))->required()->maxLength(50)]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([TextColumn::make('name')->label(__('backend.name'))->searchable()])
            ->filters([
                //
            ])
            ->recordActions([EditAction::make()->iconButton(), ActionGroup::make([DeleteAction::make()])])
            ->toolbarActions([]);
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
            'index' => ListPaymentMethods::route('/'),
            // 'create' => Pages\CreatePaymentMethod::route('/create'),
            // 'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }
}
