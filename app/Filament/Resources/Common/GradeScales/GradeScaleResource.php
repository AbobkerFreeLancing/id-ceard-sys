<?php

namespace App\Filament\Resources\Common\GradeScales;

use App\Filament\Resources\Common\GradeScales\Pages\ManageGradeScales;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Callout;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Packages\University\Models\GradeScale;

class GradeScaleResource extends Resource
{
    protected static ?string $model = GradeScale::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'grade';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.settings');
    }

    public static function getLabel(): ?string
    {
        return __('backend.grade_scale');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.grade_scales');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.grade_scales');
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
            Callout::make('dd')
                ->heading(__('backend.example'))
                ->description('تقدير A+ بأقل تقدير 85 واقصى 100')
                ->info()
                ->columnSpanFull(),
            TextInput::make('grade')->label(__('backend.grade'))->required()->maxLength(5),
            TextInput::make('grade_en')->label(__('backend.grade'))->required()->maxLength(5),
            TextInput::make('min_mark')->label(__('backend.min_mark'))->required()->numeric(),
            TextInput::make('max_mark')->label(__('backend.max_mark'))->required()->numeric(),
            TextInput::make('points')->label(__('backend.points'))->required()->numeric(),
            TextInput::make('estimation_ar')->label(__('backend.estimation_ar'))->required()->maxLength(40),
            TextInput::make('estimation_en')->label(__('backend.estimation_en'))->maxLength(40),
            Toggle::make('is_pass')->label(__('backend.is_pass')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('min_mark', 'DESC')
            ->recordTitleAttribute('grade')
            ->columns([
                TextColumn::make('grade')->label(__('backend.grade')),
                TextColumn::make('grade_en')->label(__('backend.grade')),
                TextColumn::make('min_mark')->label(__('backend.min_mark')),
                TextColumn::make('max_mark')->label(__('backend.max_mark')),
                TextColumn::make('points')->label(__('backend.points')),
                TextColumn::make('estimation_ar')->label(__('backend.estimation_ar')),
                TextColumn::make('estimation_en')->label(__('backend.estimation_en')),
                IconColumn::make('is_pass')->label(__('backend.is_pass'))->boolean(),
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
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageGradeScales::route('/'),
        ];
    }
}
