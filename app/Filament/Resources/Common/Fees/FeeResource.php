<?php

namespace App\Filament\Resources\Common\Fees;

use App\Filament\Resources\Common\Fees\Pages\ManageFees;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Packages\University\Models\Fee;

class FeeResource extends Resource
{
    protected static ?string $model = Fee::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return __('backend.fee_management_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.fee');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.fees');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.fees');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('student_id')
                ->label(__('backend.student'))
                ->relationship('student', 'full_name')
                ->required()
                ->preload()
                ->searchable(),
            Select::make('fee_type_id')
                ->label(__('backend.fee_type'))
                ->relationship('feeType', 'name')
                ->required()
                ->preload()
                ->searchable(),
            Select::make('invoice_id')
                ->label(__('backend.invoice'))
                ->relationship('invoice', 'ref_number')
                ->preload()
                ->searchable(),
            Select::make('academic_year_id')
                ->label(__('backend.academic_year'))
                ->relationship('academicYear', 'name')
                ->required()
                ->preload()
                ->searchable(),
            Select::make('semester_id')
                ->label(__('backend.semester'))
                ->relationship('semester', 'name')
                ->preload()
                ->searchable(),
            TextInput::make('amount')->label(__('backend.amount'))->numeric()->default(0.0)->required(),
            TextInput::make('notes')->label(__('backend.notes'))->maxLength(255)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('student.name')->label(__('backend.student')),
                TextColumn::make('feeType.name')->label(__('backend.fee_type')),
                TextColumn::make('invoice.ref_number')->label(__('backend.invoice')),
                TextColumn::make('academicYear.name')->label(__('backend.academic_year')),
                TextColumn::make('semester.name')->label(__('backend.semester')),
                TextColumn::make('amount')->label(__('backend.amount')),
                IconColumn::make('is_paid')->label(__('backend.is_paid'))->boolean(),
            ])
            ->filters([
                SelectFilter::make('student_id')
                    ->label(__('backend.student'))
                    ->relationship('student', 'full_name')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('fee_type_id')
                    ->label(__('backend.fee_type'))
                    ->relationship('feeType', 'name')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('academic_year_id')
                    ->label(__('backend.academic_year'))
                    ->relationship('academicYear', 'name')
                    ->preload()
                    ->searchable(),
            ])
            ->recordActions([
                //
                EditAction::make()->iconButton()->modalWidth('2xl'),
                ActionGroup::make([
                    //
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFees::route('/'),
        ];
    }
}
