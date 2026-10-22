<?php

namespace App\Filament\Resources\University\Semesters;

use App\Filament\Resources\University\Semesters\Pages\ManageSemesters;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Packages\University\Models\Semester;

class SemesterResource extends Resource
{
    protected static ?string $model = Semester::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 7;

    public static function getNavigationGroup(): string
    {
        return __('backend.academic_structure_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.semester');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.semesters');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.semesters');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('study_year_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('study_year_management');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            //
            TextInput::make('name')->label(__('backend.name'))->maxLength(80)->required(),
            TextInput::make('name_en')->label(__('backend.name_en'))->maxLength(80),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            //
            TextEntry::make('name')->label(__('backend.name')),
            TextEntry::make('name_en')->label(__('backend.name_en')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order', 'ASC')
            ->recordTitleAttribute('name')
            ->columns([
                //
                TextColumn::make('name')->label(__('backend.name')),
                TextColumn::make('name_en')->label(__('backend.name_en')),
                ToggleColumn::make('is_active')->label(__('backend.is_active')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
                ViewAction::make()->hidden(),
                EditAction::make()->iconButton()->hidden(),
                DeleteAction::make()->hidden(),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSemesters::route('/'),
        ];
    }
}
