<?php

namespace App\Filament\Resources\Common\Users\Tables;

use Packages\Enum\Profile\UserAccountStatusEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn($query) => auth()->user()->hasRole('dev')
                    ? $query->where('id', '>', 0)->where('type', 'user') : $query->whereDoesntHave('roles', function ($q) {
                        $q->where('name', 'dev');
                    })->where('type', 'user')
            )
            ->defaultSort('created_at', 'desc')
            ->recordUrl(null)
            ->columns([
                TextColumn::make('name')->label(__('backend.name')),
                TextColumn::make('roles.description')->label(__('backend.roles_jobs')),
                TextColumn::make('account_status')
                    ->label(__('backend.status'))
                    ->badge()
                    ->formatStateUsing(fn($record) => UserAccountStatusEnum::from($record->account_status)->getLabel())
                    ->color(fn($record) => UserAccountStatusEnum::from($record->account_status)->getColor()),
                TextColumn::make('phone')->label(__('backend.phone'))->searchable(),
                TextColumn::make('email')->label(__('backend.email'))->searchable(),
                TextColumn::make('created_at')->label(__('backend.created_at'))->date(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->schema([
                        // 1. Quick Range Dropdown
                        Select::make('quick_range')
                            ->label(__('backend.date_range'))
                            ->hidden()
                            ->options([
                                'today' => __('backend.today_24'),
                                'last_week_7' => __('backend.last_week_7'),
                                'this_month' => __('backend.last_month_30'),
                            ])
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Automatically populate the custom date pickers based on selection
                                if ($state === 'today') {
                                    $set('from', Carbon::now()->startOfDay()->toDateString());
                                    $set('until', Carbon::now()->endOfDay()->toDateString());
                                } elseif ($state === 'last_week_7') {
                                    $set('from', Carbon::now()->subDays(6)->toDateString());
                                    $set('until', Carbon::now()->toDateString());
                                } elseif ($state === 'this_month') {
                                    $set('from', Carbon::now()->subDays(29)->toDateString());
                                    $set('until', Carbon::now()->toDateString());
                                }
                            }),

                        // 2. Custom Date Pickers
                        DatePicker::make('from')
                            ->label(__('backend.from_date')),
                        DatePicker::make('until')
                            ->label(__('backend.to_date')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                SelectFilter::make('roles')
                    ->relationship('roles', 'description', fn($query) => $query->where('name', '!=', 'dev'))
                    ->label(__('backend.roles_jobs'))
                    ->multiple(),
                TrashedFilter::make(),
            ])
            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label(__('backend.filters')),
            )
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                RestoreAction::make(),
                ActionGroup::make([
                    Action::make('update_password')
                        ->label(__('backend.update_password'))
                        ->modalAlignment(Alignment::Center)
                        ->modalWidth(Width::Medium)
                        ->modalIcon(Heroicon::OutlinedKey)
                        ->icon(Heroicon::OutlinedKey)
                        ->after(function () {
                            Notification::make()
                                ->title(__('backend.password_reset_successfuly'))
                                ->success()
                                ->send();
                        })
                        ->action(function ($record, array $data): void {
                            $record->password = Hash::make($data['password']);
                            $record->save();
                        })
                        ->schema([
                            TextEntry::make('user')->label(fn($record) => $record->name),
                            TextInput::make('password')->label(__('backend.password'))
                                ->password()
                                ->revealable()
                                ->minLength(6)
                                ->maxLength(40)
                                ->required()
                        ]),
                    Action::make('account_status_change')
                        ->label(__('backend.account_status_change'))
                        ->modalAlignment(Alignment::Center)
                        ->color('warning')
                        ->modalWidth(Width::Medium)
                        ->modalIcon(Heroicon::OutlinedKey)
                        ->icon(Heroicon::OutlinedUser)
                        ->after(function () {
                            Notification::make()
                                ->title(__('backend.operation_successfuly'))
                                ->success()
                                ->send();
                        })
                        ->action(function ($record, array $data): void {
                            $record->account_status = $data['new_status'];
                            $record->ban_reason = array_key_exists('ban_reason',$data) ? $data['ban_reason'] : '';
                            $record->save();
                        })
                        ->schema([
                            TextEntry::make('name')->label(__('backend.name')),
                            TextEntry::make('user.account_status')
                                ->label(__('backend.status'))
                                ->getStateUsing(fn($record) => UserAccountStatusEnum::from($record->account_status)->getLabel()),
                            Radio::make('new_status')
                                ->label(__('backend.new_status'))
                                ->inline(true)
                                ->options(fn($record) => UserAccountStatusEnum::getOptionsExcept($record->account_status))
                                ->reactive()
                                ->required(),
                            TextInput::make('ban_reason')
                                ->label(__('backend.ban_reason'))
                                ->visible(fn(Get $get) => $get('new_status') == UserAccountStatusEnum::Banned->value)
                                ->required(fn(Get $get) => $get('new_status') == UserAccountStatusEnum::Banned->value)
                        ]),
                    DeleteAction::make()
                        ->label(__('backend.action_delete_trash'))
                        ->modalHeading(fn($record) => __('backend.action_delete') . " " . $record->name),
                ]),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
