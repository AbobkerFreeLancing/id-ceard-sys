<?php

namespace App\Filament\Resources\University\CertificateTypes;

use App\Filament\Resources\University\CertificateTypes\Pages\ManageCertificateTypes;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Packages\University\Models\CertificateType;

class CertificateTypeResource extends Resource
{
    protected static ?string $model = CertificateType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.settings');
    }

    public static function getLabel(): ?string
    {
        return __('backend.certificate_type');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.certificate_types');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.certificate_types');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('settings_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('settings_management');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            //
            TextInput::make('name')->label(__('backend.name'))->unique(ignoreRecord: true)->required()->maxLength(100),
            TextInput::make('name_en')->label(__('backend.name_en'))->unique(ignoreRecord: true)->maxLength(100),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                //
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('name_en')->label(__('backend.name_en')),
                ToggleColumn::make('is_active')->label(__('backend.is_active')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
                EditAction::make()->iconButton()->modalWidth('lg'),
                DeleteAction::make()->hidden(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCertificateTypes::route('/'),
        ];
    }
}
