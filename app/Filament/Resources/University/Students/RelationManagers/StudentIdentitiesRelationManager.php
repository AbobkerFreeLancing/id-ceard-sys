<?php

namespace App\Filament\Resources\University\Students\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Packages\University\Enums\IdentityTypeEnum;

class StudentIdentitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'identities';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('backend.identities');
    }

    public static function modelLabel(): ?string
    {
        return __('backend.identity');
    }

    protected static function getPluralModelLabel(): string
    {
        return __('backend.identities');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('attachment')
                    ->image()
                    ->required()
                    ->directory(fn($livewire) => 'students/' . $livewire->ownerRecord->university_no . '/identities')
                    ->maxFiles(1)
                    ->maxSize(1024)
                    ->label(__('backend.attachment')),
                Select::make('type')
                    ->label(__('backend.type'))
                    ->required()
                    ->options(IdentityTypeEnum::getOptions())
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                TextInput::make('notes')->maxLength(100)->label(__('backend.notes'))->columnSpanFull(),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('ref_number')
            ->columns([
                //
                TextColumn::make('type')->formatStateUsing(fn($state) => $state->getLabel())->label(__('backend.type')),
                ImageColumn::make('attachment')->label(__('backend.attachment')),
                TextColumn::make('created_at')->label(__('backend.added_at')),
                IconColumn::make('is_approved')->label(__('backend.approved'))->boolean(),
                TextColumn::make('notes')->label(__('backend.notes')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
                CreateAction::make()->createAnother(false)->modalWidth('lg'),
            ])
            ->recordActions([
                //
                Action::make('approved_action')
                    ->label(__('backend.approve'))
                    ->icon(Heroicon::CheckCircle)
                    ->button()
                    ->outlined()
                    ->hidden(fn($record) => $record->is_approved == true)
                    ->action(function ($record) {
                        $record->update([
                            'is_approved' => true,
                            'approved_by' => auth()->user()->id,
                        ]);
                    })
                    ->requiresConfirmation(),
                EditAction::make()->iconButton()->modalWidth('lg'),
                ActionGroup::make([
                    //
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([]);
    }
}
