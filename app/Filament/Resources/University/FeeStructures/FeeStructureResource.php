<?php

namespace App\Filament\Resources\University\FeeStructures;

use App\Filament\Resources\University\FeeStructures\Pages\ApplyFeeStructure;
use App\Filament\Resources\University\FeeStructures\Pages\CreateFeeStructure;
use App\Filament\Resources\University\FeeStructures\Pages\EditFeeStructure;
use App\Filament\Resources\University\FeeStructures\Pages\ListFeeStructures;
use App\Filament\Resources\University\FeeStructures\Pages\ViewFeeStructure;
use App\Filament\Resources\University\FeeStructures\Schemas\FeeStructureForm;
use App\Filament\Resources\University\FeeStructures\Schemas\FeeStructureInfolist;
use App\Filament\Resources\University\FeeStructures\Tables\FeeStructuresTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\FeeStructure;

class FeeStructureResource extends Resource
{
    protected static ?string $model = FeeStructure::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('backend.fee_management_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.fee_structure');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.fee_structure');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.fee_structure');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('fee_structure_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('fee_structure_management');
    }

    public static function form(Schema $schema): Schema
    {
        return FeeStructureForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FeeStructureInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FeeStructuresTable::configure($table);
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
            'index' => ListFeeStructures::route('/'),
            'create' => CreateFeeStructure::route('/create'),
            // 'view' => ViewFeeStructure::route('/{record}'),
            'edit' => EditFeeStructure::route('/{record}/edit'),
            'apply-structure' => ApplyFeeStructure::route('/{record}/apply-fees'),
        ];
    }
}
