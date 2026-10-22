<?php

namespace App\Filament\Resources\University\InstallmentPlans;

use App\Filament\Resources\University\InstallmentPlans\Pages\CreateInstallmentPlan;
use App\Filament\Resources\University\InstallmentPlans\Pages\EditInstallmentPlan;
use App\Filament\Resources\University\InstallmentPlans\Pages\ListInstallmentPlans;
use App\Filament\Resources\University\InstallmentPlans\Pages\ViewInstallmentPlan;
use App\Filament\Resources\University\InstallmentPlans\Schemas\InstallmentPlanForm;
use App\Filament\Resources\University\InstallmentPlans\Schemas\InstallmentPlanInfolist;
use App\Filament\Resources\University\InstallmentPlans\Tables\InstallmentPlansTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\InstallmentPlan;

class InstallmentPlanResource extends Resource
{
    protected static ?string $model = InstallmentPlan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): string
    {
        return __('backend.fee_management_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.installment_plan');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.installment_plans');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.installment_plans');
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
        return InstallmentPlanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InstallmentPlanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstallmentPlansTable::configure($table);
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
            'index' => ListInstallmentPlans::route('/'),
            'create' => CreateInstallmentPlan::route('/create'),
            'view' => ViewInstallmentPlan::route('/{record}'),
            'edit' => EditInstallmentPlan::route('/{record}/edit'),
        ];
    }
}
