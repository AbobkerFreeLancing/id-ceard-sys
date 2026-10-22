<?php

namespace App\Filament\Resources\University\MedicalCheckups\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Packages\University\Enums\MedicalCheckupStatusEnum;
use Packages\University\Models\Student;

class MedicalCheckupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')->label(__('backend.student'))->searchable(
                    query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('student', function ($q) use ($search) {
                            $q->where('first_name', 'like', "%{$search}%")
                                ->orWhere('second_name', 'like', "%{$search}%")
                                ->orWhere('third_name', 'like', "%{$search}%")
                                ->orWhere('fourth_name', 'like', "%{$search}%");
                        });
                    },
                ),
                TextColumn::make('student.university_no')->label(__('backend.university_no'))->searchable(
                    query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('student', function ($q) use ($search) {
                            $q->where('university_no', 'like', "%{$search}%");
                        });
                    },
                ),
                TextColumn::make('status')
                    ->badge()
                    ->state(fn($record) => $record->status->getLabel())
                    ->label(__('backend.status')),
                TextColumn::make('blood_group')->label(__('backend.blood_group')),
                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('college_id')
                    ->label(__('backend.college'))
                    ->relationship('college', 'name')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('student_id')
                    ->label(__('backend.student'))
                    ->options(Student::get()->pluck('name', 'id'))
                    ->preload()
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                Action::make('medical_state_update')
                    ->label(__('backend.medical_state_update'))
                    ->modalWidth('xl')
                    ->icon(Heroicon::Lifebuoy)
                    ->action(function ($record, $data) {
                        $record->update([
                            'status' => $data['status'],
                        ]);
                    })
                    ->schema([
                        Group::make([
                            //
                            TextEntry::make('student.name')->label(__('backend.student')),
                            TextEntry::make('status')
                                ->state(fn($record) => $record->status->getLabel())
                                ->label(__('backend.current_status')),
                            Radio::make('status')
                                ->label(__('backend.new_status'))
                                ->options(
                                    array_filter(
                                        MedicalCheckupStatusEnum::getOptions(),
                                        fn($key) => $key !== MedicalCheckupStatusEnum::Pending->value,
                                        ARRAY_FILTER_USE_KEY,
                                    ),
                                )
                                ->inline(true)
                                ->default(fn($record) => $record->status)
                                ->required()
                                ->columnSpanFull(),
                        ])->columns(1),
                    ]),
                ActionGroup::make([
                    //
                    DeleteAction::make()->hidden(),
                ]),
            ])
            ->toolbarActions([BulkActionGroup::make([])]);
    }
}
