<?php

namespace App\Filament\Resources\University\CertificateRequests\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Packages\University\Models\Student;

class CertificateRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('serial_no')->label(__('backend.serial_no')),
                TextColumn::make('student.name')->label(__('backend.student')),
                TextColumn::make('created_at')->label(__('backend.created_at'))->date(),
            ])
            ->filters([
                SelectFilter::make('student_id')
                    ->label(__('backend.student'))
                    ->options(Student::get()->pluck('name', 'id'))
                    ->preload()
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([
                    //
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
