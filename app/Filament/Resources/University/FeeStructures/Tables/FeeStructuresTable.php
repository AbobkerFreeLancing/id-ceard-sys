<?php

namespace App\Filament\Resources\University\FeeStructures\Tables;

use App\Filament\Resources\University\FeeStructures\FeeStructureResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Callout;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FeeStructuresTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('acceptanceType.name')->label(__('backend.acceptance_type')),
                TextColumn::make('college.name')->default('-')->label(__('backend.college')),
                TextColumn::make('fees_total')
                    ->formatStateUsing(
                        fn($record) => number_format($record->feesTotal) . ' ' . $record->currency->symbol,
                    )
                    ->label(__('backend.fees_total'))
                    ->badge()
                    ->color('gray'),
                TextColumn::make('academicYear.name')->label(__('backend.academic_year')),
                IconColumn::make('is_approved')->label(__('backend.approved'))->boolean(),
            ])
            ->filters([
                SelectFilter::make('acceptance_type_id')
                    ->label(__('backend.acceptance_type'))
                    ->relationship('acceptanceType', 'name'),
                SelectFilter::make('college_id')->label(__('backend.college'))->relationship('college', 'name'),
                SelectFilter::make('academic_year_id')
                    ->label(__('backend.academic_year'))
                    ->relationship('academicYear', 'name', fn($query) => $query->where('is_active', true))
                    ->preload()
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make()->iconButton()->modalHeading(__('backend.fee_structure')),
                EditAction::make()->iconButton()->hidden(fn($record) => $record->is_approved),
                Action::make('apply_fee_structure')
                    ->icon(Heroicon::CurrencyDollar)
                    ->hidden(fn($record) => !$record->is_approved)
                    ->label(__('backend.apply_fee_structure'))
                    ->url(fn($record) => FeeStructureResource::getUrl('apply-structure', [$record->id])),
                Action::make('action_approve')
                    ->label(__('backend.approve'))
                    ->icon(Heroicon::CheckCircle)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->hidden(fn($record) => $record->is_approved)
                    ->schema([
                        Callout::make('cant_edit')
                            ->icon(Heroicon::ExclamationTriangle)
                            ->heading(__('backend.note'))
                            ->description(__('backend.cant_edit_approved'))
                            ->danger(),
                    ])
                    ->action(function ($record) {
                        $record->update([
                            'is_approved' => true,
                            'approved_at' => now(),
                            'approved_by' => auth()->user()->id,
                        ]);
                    }),
                ActionGroup::make([
                    //
                    DeleteAction::make()->disabled(fn($record) => $record->is_approved),
                ]),
            ])
            ->toolbarActions([]);
    }
}
