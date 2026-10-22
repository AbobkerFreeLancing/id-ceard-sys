<?php

namespace App\Filament\Resources\Common\Notes;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Packages\Common\Models\Note;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\Common\Notes\Pages\EditNote;
use App\Filament\Resources\Common\Notes\Pages\ListNotes;
use App\Filament\Resources\Common\Notes\Pages\CreateNote;
use App\Filament\Resources\Common\Notes\Schemas\NoteForm;
use App\Filament\Resources\Common\Notes\Tables\NotesTable;

class NoteResource extends Resource
{
    protected static ?string $model = Note::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::PencilSquare;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getLabel(): ?string
    {
        return __('backend.notes');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.notes');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.notes'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('bedaya.notes_enabled') && auth()->user()->can('note_management');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('note_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('note_management');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('note_management');
    }

    public static function form(Schema $schema): Schema
    {
        return NoteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NotesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNotes::route('/'),
            // 'create' => CreateNote::route('/create'),
            // 'edit' => EditNote::route('/{record}/edit'),
        ];
    }
}
