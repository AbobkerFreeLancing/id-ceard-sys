<?php

namespace App\Filament\Resources\DocsModule\Projects\RelationManagers;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\CodeEditor\Enums\Language;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectSectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(__('backend.title'))
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(50),
                TextInput::make('description')
                    ->label(__('backend.description'))
                    ->maxLength(100)
                    ->columnSpanFull(),
                Repeater::make('items')
                    ->relationship('items')
                    ->label(__('backend.items'))
                    ->itemLabel(fn($state) => $state['title'] ?? '-')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label(__('backend.title'))
                            ->required()
                            ->maxLength(50),
                        TextInput::make('endpoint')
                            ->label('Endpoint')
                            ->maxLength(50),
                        TextInput::make('description')
                            ->label('Description')
                            ->maxLength(150)
                            ->columnSpanFull(),
                        Select::make('request_method')
                            ->label('Request Method')
                            ->options([
                                'GET' => 'GET',
                                'POST' => 'POST',
                                'PUT' => 'PUT',
                                'DELETE' => 'DELETE',
                            ]),
                        CodeEditor::make('content')
                            ->label(__('backend.content'))
                            ->columnSpanFull()
                            ->required(),
                    ])
                    ->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('order_column', 'ASC')
            ->reorderable('order_column')
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('order_column')->label(__('backend.order_column')),
                TextColumn::make('title')->label(__('backend.title')),
                TextColumn::make('description')->label(__('backend.description')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->slideOver()
                    ->createAnother(false),
            ])
            ->recordActions([
                EditAction::make()
                    ->iconButton()
                    ->slideOver(),
                ActionGroup::make([
                    DeleteAction::make()
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
