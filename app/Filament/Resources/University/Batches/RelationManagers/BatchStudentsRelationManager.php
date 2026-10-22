<?php

namespace App\Filament\Resources\University\Batches\RelationManagers;

use App\Filament\Resources\University\Students\StudentResource;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BatchStudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('backend.students');
    }

    public static function modelLabel(): ?string
    {
        return __('backend.student');
    }

    protected static function getPluralModelLabel(): string
    {
        return __('backend.students');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                //
                TextColumn::make('full_name')->label(__('backend.full_name'))->searchable(),
                TextColumn::make('university_no')->label(__('backend.university_no'))->searchable(),
                TextColumn::make('created_at')->label(__('backend.created_at')),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->recordActions([
                //
                Action::make('view_student')
                    ->label(__('backend.action_view'))
                    ->icon(Heroicon::Eye)
                    ->url(fn($record) => StudentResource::getUrl('view', [$record->id])),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
