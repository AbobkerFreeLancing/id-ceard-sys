<?php

namespace App\Filament\Resources\DocsModule\Projects;

use App\Filament\Resources\DocsModule\Projects\Pages\CreateProject;
use App\Filament\Resources\DocsModule\Projects\Pages\EditProject;
use App\Filament\Resources\DocsModule\Projects\Pages\ListProjects;
use App\Filament\Resources\DocsModule\Projects\Pages\ViewProject;
use App\Filament\Resources\DocsModule\Projects\RelationManagers\ProjectItemsRelationManager;
use App\Filament\Resources\DocsModule\Projects\RelationManagers\ProjectSectionsRelationManager;
use App\Filament\Resources\DocsModule\Projects\Schemas\ProjectForm;
use App\Filament\Resources\DocsModule\Projects\Schemas\ProjectInfolist;
use App\Filament\Resources\DocsModule\Projects\Tables\ProjectsTable;
use BackedEnum;
use Packages\DocsModule\Models\Project;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.docs_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.documetation');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.documetations');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.documetations');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('bedaya.docs_module_enabled');
    }

    public static function form(Schema $schema): Schema
    {
        return ProjectForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProjectInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ProjectSectionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'view' => ViewProject::route('/{record}'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
