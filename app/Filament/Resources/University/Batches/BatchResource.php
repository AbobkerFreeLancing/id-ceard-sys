<?php

namespace App\Filament\Resources\University\Batches;

use App\Filament\Resources\University\Batches\Pages\CreateBatch;
use App\Filament\Resources\University\Batches\Pages\EditBatch;
use App\Filament\Resources\University\Batches\Pages\ListBatches;
use App\Filament\Resources\University\Batches\Pages\ViewBatch;
use App\Filament\Resources\University\Batches\RelationManagers\BatchStudentsRelationManager;
use App\Filament\Resources\University\Batches\Schemas\BatchForm;
use App\Filament\Resources\University\Batches\Schemas\BatchInfolist;
use App\Filament\Resources\University\Batches\Tables\BatchesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\Batch;

class BatchResource extends Resource
{
    protected static ?string $model = Batch::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'ref_number';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('backend.student_affairs_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.batch');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.batches');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.batches');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('batch_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('batch_management');
    }

    public static function form(Schema $schema): Schema
    {
        return BatchForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BatchInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BatchesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
                //
                // BatchStudentsRelationManager::class,
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBatches::route('/'),
            'create' => CreateBatch::route('/create'),
            'view' => ViewBatch::route('/{record}'),
            'edit' => EditBatch::route('/{record}/edit'),
        ];
    }
}
