<?php

namespace App\Filament\Resources\Common\Branches;

use App\Filament\Resources\Common\Branches\Pages\CreateBranch;
use App\Filament\Resources\Common\Branches\Pages\EditBranch;
use App\Filament\Resources\Common\Branches\Pages\ListBranches;
use App\Filament\Resources\Common\Branches\Pages\ViewBranch;
use App\Filament\Resources\Common\Branches\Schemas\BranchForm;
use App\Filament\Resources\Common\Branches\Schemas\BranchInfolist;
use App\Filament\Resources\Common\Branches\Tables\BranchesTable;
use BackedEnum;
use Packages\Common\Models\Branch;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getLabel(): ?string
    {
        return __('backend.branch');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.branches');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.branches');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('branch_management');
    }

    public static function canCreate(): bool
    {
        return Branch::count() < config('bedaya.branch_count');
    }

    public static function canEdit(Model $record): bool
    {
        return $record->is_editable;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return BranchForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BranchInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BranchesTable::configure($table);
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
            'index' => ListBranches::route('/'),
            'create' => CreateBranch::route('/create'),
            'view' => ViewBranch::route('/{record}'),
            'edit' => EditBranch::route('/{record}/edit'),
        ];
    }
}
