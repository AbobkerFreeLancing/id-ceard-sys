<?php

namespace App\Filament\Resources\University\BatchTransitions;

use App\Filament\Resources\University\BatchTransitions\Pages\CreateBatchTransition;
use App\Filament\Resources\University\BatchTransitions\Pages\EditBatchTransition;
use App\Filament\Resources\University\BatchTransitions\Pages\ListBatchTransitions;
use App\Filament\Resources\University\BatchTransitions\Pages\ViewBatchTransition;
use App\Filament\Resources\University\BatchTransitions\Schemas\BatchTransitionForm;
use App\Filament\Resources\University\BatchTransitions\Schemas\BatchTransitionInfolist;
use App\Filament\Resources\University\BatchTransitions\Tables\BatchTransitionsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\BatchTransition;

class BatchTransitionResource extends Resource
{
    protected static ?string $model = BatchTransition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.student_affairs_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.batch_transition');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.batch_transitions');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.batch_transitions');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('batch_transition_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('batch_transition_management');
    }

    public static function form(Schema $schema): Schema
    {
        return BatchTransitionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BatchTransitionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BatchTransitionsTable::configure($table);
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
            'index' => ListBatchTransitions::route('/'),
            'create' => CreateBatchTransition::route('/create'),
            'view' => ViewBatchTransition::route('/{record}'),
            'edit' => EditBatchTransition::route('/{record}/edit'),
        ];
    }
}
