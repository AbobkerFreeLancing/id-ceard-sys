<?php

namespace App\Filament\Resources\Common\Notes\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Packages\Enum\NoteStatusEnum;
use Packages\Enum\PriorityEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\Width;
use Filament\Actions\DeleteAction;
use Filament\Actions\SelectAction;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Radio;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\ToggleButtons;

class NotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('title')->label(__('backend.title'))->searchable(),
                TextColumn::make('content')->label(__('backend.content'))->wrap(),
                TextColumn::make('status_label')
                    ->icon(Heroicon::OutlinedEye)
                    ->label(__('backend.status'))
                    ->badge()
                    ->color(fn($record) => match ($record->status) {
                        NoteStatusEnum::Todo->value => Color::Gray,
                        NoteStatusEnum::InProgress->value => Color::Yellow,
                        NoteStatusEnum::Done->value => Color::Blue,
                        NoteStatusEnum::FuturePlan->value => Color::Green,
                        NoteStatusEnum::Canceled->value => Color::Red,
                    }),
                TextColumn::make('priority_label')
                    ->icon(Heroicon::OutlinedClock)
                    ->label(__('backend.priority'))
                    ->badge()
                    ->color(fn($record) => match ($record->priority) {
                        'low' => Color::Gray,
                        'medium' => Color::Yellow,
                        'high' => Color::Orange,
                        'urgent' => Color::Red,
                    }),
                TextColumn::make('created_at')->label(__('backend.created_at')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->iconButton()->modalWidth(Width::Medium),
                ActionGroup::make([
                    Action::make('update_status')
                        ->label(__('backend.update_status'))
                        ->icon('heroicon-o-eye')
                        ->color(Color::Orange)
                        ->modalWidth(Width::Large)
                        ->schema([
                            ToggleButtons::make('status_choice')
                                ->label(__('backend.status'))
                                ->options([
                                    NoteStatusEnum::Todo->value => NoteStatusEnum::Todo->label(),
                                    NoteStatusEnum::InProgress->value => NoteStatusEnum::InProgress->label(),
                                    NoteStatusEnum::Done->value => NoteStatusEnum::Done->label(),
                                    NoteStatusEnum::FuturePlan->value => NoteStatusEnum::FuturePlan->label(),
                                    NoteStatusEnum::Canceled->value => NoteStatusEnum::Canceled->label(),
                                ])
                                ->colors([
                                    NoteStatusEnum::Todo->value => Color::Gray,
                                    NoteStatusEnum::InProgress->value => Color::Yellow,
                                    NoteStatusEnum::Done->value => Color::Blue,
                                    NoteStatusEnum::FuturePlan->value => Color::Green,
                                    NoteStatusEnum::Canceled->value => Color::Red,
                                ])
                                ->default(NoteStatusEnum::Todo->value)
                                ->required(),
                        ])
                        ->action(function ($record, $data) {
                            $record->update([
                                'status' => $data['status_choice'],
                            ]);
                        }),
                    Action::make('priority_update_action')
                        ->label(__('backend.priority_update_action'))
                        ->icon(Heroicon::OutlinedClock)
                        ->color(Color::Gray)
                        ->modalWidth(Width::Large)
                        ->schema([
                            ToggleButtons::make('priority_choice')
                                ->label(__('backend.priority'))
                                ->options([
                                    PriorityEnum::Low->value => PriorityEnum::Low->label(),
                                    PriorityEnum::Medium->value => PriorityEnum::Medium->label(),
                                    PriorityEnum::High->value => PriorityEnum::High->label(),
                                    PriorityEnum::Urgent->value => PriorityEnum::Urgent->label(),
                                ])
                                ->colors([
                                    PriorityEnum::Low->value => Color::Gray,
                                    PriorityEnum::Medium->value => Color::Yellow,
                                    PriorityEnum::High->value => Color::Blue,
                                    PriorityEnum::Urgent->value => Color::Red,
                                ])
                                ->default(PriorityEnum::Medium->value)
                                ->required(),
                        ])
                        ->action(function ($record, $data) {
                            $record->update([
                                'priority' => $data['priority_choice'],
                            ]);
                        }),


                    DeleteAction::make(),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn() => auth()->user()->hasRole('dev')),
                ]),
            ]);
    }
}
