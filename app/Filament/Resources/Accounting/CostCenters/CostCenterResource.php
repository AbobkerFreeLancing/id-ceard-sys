<?php

namespace App\Filament\Resources\Accounting\CostCenters;

use App\Filament\Resources\Accounting\CostCenters\Pages\CreateCostCenter;
use App\Filament\Resources\Accounting\CostCenters\Pages\EditCostCenter;
use App\Filament\Resources\Accounting\CostCenters\Pages\ListCostCenters;
use App\Filament\Resources\Accounting\CostCenters\Pages\ViewCostCenter;
use App\Filament\Resources\Accounting\CostCenters\Schemas\CostCenterForm;
use App\Filament\Resources\Accounting\CostCenters\Schemas\CostCenterInfolist;
use App\Filament\Resources\Accounting\CostCenters\Tables\CostCentersTable;
use BackedEnum;
use Packages\Accounting\Models\CostCenter;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CostCenterResource extends Resource
{
    protected static ?string $model = CostCenter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function getLabel(): ?string
    {
        return __('backend.cost_center');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.cost_centers');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.cost_centers');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return CostCenterForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CostCenterInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CostCentersTable::configure($table);
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
            'index' => ListCostCenters::route('/'),
            'create' => CreateCostCenter::route('/create'),
            'view' => ViewCostCenter::route('/{record}'),
            'edit' => EditCostCenter::route('/{record}/edit'),
        ];
    }
}
