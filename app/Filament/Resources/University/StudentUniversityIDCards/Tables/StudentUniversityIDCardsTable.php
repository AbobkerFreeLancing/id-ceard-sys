<?php

namespace App\Filament\Resources\University\StudentUniversityIDCards\Tables;

use App\Filament\Resources\University\StudentUniversityIDCards\StudentUniversityIDCardResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentUniversityIDCardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ref_number')->label(__('backend.card_number'))->searchable(),
                TextColumn::make('student.name')->label(__('backend.student')),
                TextColumn::make('expiry_date')->label(__('backend.expire_date'))->date(),
                IconColumn::make('is_approved')->label(__('backend.approved'))->boolean(),
                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // SelectFilter::make('student_id')
                //     ->label(__('backend.student'))
                //     ->relationship('student', 'name')
                //     ->preload()
                //     ->searchable(),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                Action::make('print')->label(__('backend.print'))->icon('heroicon-o-printer')->url(
                    fn($record): string => StudentUniversityIDCardResource::getUrl('print', [
                        'record' => $record,
                    ]),
                ),
                EditAction::make()->iconButton(),
                ActionGroup::make([
                    //
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
