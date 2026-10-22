<?php

namespace App\Filament\Resources\University\Departments;

use App\Filament\Resources\University\Departments\Pages\CreateDepartment;
use App\Filament\Resources\University\Departments\Pages\EditDepartment;
use App\Filament\Resources\University\Departments\Pages\ListDepartments;
use App\Filament\Resources\University\Departments\Pages\ViewDepartment;
use App\Filament\Resources\University\Departments\Schemas\DepartmentForm;
use App\Filament\Resources\University\Departments\Schemas\DepartmentInfolist;
use App\Filament\Resources\University\Departments\Tables\DepartmentsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\Department;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('backend.academic_structure_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.department');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.departments');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.departments');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('department_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('department_management');
    }

    public static function form(Schema $schema): Schema
    {
        return DepartmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DepartmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DepartmentsTable::configure($table);
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
            'index' => ListDepartments::route('/'),
            'create' => CreateDepartment::route('/create'),
            'view' => ViewDepartment::route('/{record}'),
            'edit' => EditDepartment::route('/{record}/edit'),
        ];
    }
}
