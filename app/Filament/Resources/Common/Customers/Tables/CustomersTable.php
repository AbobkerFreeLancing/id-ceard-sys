<?php

namespace App\Filament\Resources\Common\Customers\Tables;

use App\Filament\Resources\Warehouse\SaleResource;
use App\Models\User;
use Packages\Common\Models\Customer;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\Size;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'DESC')
            ->columns([
                TextColumn::make('user.name')->label(__('backend.name'))->searchable(),
                TextColumn::make('user.account.currency.symbol')->label(__('backend.the_currency'))->searchable(),
                TextColumn::make('user.account.balance')
                    ->label(__('backend.balance'))
                    ->formatStateUsing(fn($state) => number_format($state, 2)),
                TextColumn::make('user.phone')->label(__('backend.phone')),
                TextColumn::make('user.address')
                    ->label(__('backend.address'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.email')->label(__('backend.email'))->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')->label(__('backend.added_at'))->date(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('created_from')->native(false)->label(__('backend.creation_date_from')),
                        DatePicker::make('created_until')
                            ->native(false)
                            ->label(__('backend.creation_date_to'))
                            ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                Action::make('sale_create')
                    ->icon('heroicon-o-plus')
                    ->color(Color::Zinc)
                    ->visible(fn() => config('bedaya.products_invoices_enabled'))
                    ->url(fn($record) => SaleResource::getUrl('create', ['customer_id' => $record->id]))
                    ->label(__('backend.sales_invoice')),

                Action::make('account_movement')
                    ->icon('heroicon-o-document-text')
                    ->slideOver()
                    ->color(Color::Amber)
                    ->modalContent(
                        fn(Customer $record): View => view('filament.resources.view-customer-movements', [
                            'record' => $record,
                        ]),
                    )
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->label(__('backend.account_movement')),

                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([
                    Action::make('update_password')
                        ->label(__('backend.update_password'))
                        ->modalAlignment(Alignment::Center)
                        ->modalWidth(Width::Medium)
                        ->modalIcon(Heroicon::OutlinedKey)
                        ->icon(Heroicon::OutlinedKey)
                        ->after(function () {
                            Notification::make()->title(__('backend.password_reset_successfuly'))->success()->send();
                        })
                        ->action(function ($record, array $data): void {
                            $record->user->password = Hash::make($data['password']);
                            $record->user->save();
                        })
                        ->schema([
                            TextEntry::make('user.name')->label(__('backend.name')),
                            TextInput::make('password')
                                ->label(__('backend.password'))
                                ->password()
                                ->revealable()
                                ->minLength(6)
                                ->maxLength(40)
                                ->required(),
                        ]),
                    DeleteAction::make()
                        ->disabled(fn($record) => $record?->sales()?->count() > 0)
                        ->after(function ($record) {
                            $record?->user->account?->delete();
                        }),
                ]),
            ])
            ->toolbarActions([
                ExportBulkAction::make()
                    ->size(Size::Small)
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->outlined()
                    ->exports([
                        ExcelExport::make()->withColumns([
                            Column::make('id'),
                            Column::make('name'),
                            Column::make('account.currency.symbol'),
                            Column::make('account.balance'),
                            Column::make('address'),
                            Column::make('phone'),
                            Column::make('created_at'),
                        ]),
                    ]),
            ]);
    }
}
