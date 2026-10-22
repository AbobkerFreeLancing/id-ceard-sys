<?php

namespace App\Filament\Resources\Accounting;

use App\Filament\Resources\Accounting\JournalResource\Pages\CreateJournal;
use App\Filament\Resources\Accounting\JournalResource\Pages\EditJournal;
use App\Filament\Resources\Accounting\JournalResource\Pages\ListJournals;
use App\Filament\Resources\Accounting\JournalResource\Pages\ViewJournal;
use App\Models\Setting;
use Packages\Accounting\Enum\AccountLevelTypeEnum;
use Packages\Accounting\Models\Account;
use Packages\Accounting\Models\Journal;
use Packages\Helpers\BedayaHelper;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class JournalResource extends Resource
{
    protected static ?string $model = Journal::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-at-symbol';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('journals_management') &&
            config('bedaya.accounting_enabled') &&
            config('bedaya.journals_enabled');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('journals_management') &&
            config('bedaya.accounting_enabled') &&
            config('bedaya.journals_enabled');
    }

    public static function getLabel(): ?string
    {
        return __('backend.journal');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.journals');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.journals'));
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('journals_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('journals_management') && !$record->is_approved;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('journals_management') && !$record->is_approved;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()
                ->compact()
                ->schema([
                    DatePicker::make('the_date')
                        ->label(__('backend.journal_date'))
                        ->default(now())
                        ->native(false)
                        ->prefixIcon(Heroicon::OutlinedCalendar)
                        ->required(),
                    TextInput::make('statement')
                        ->label(__('backend.statement'))
                        ->prefixIcon(Heroicon::OutlinedInformationCircle)
                        ->required()
                        ->maxLength(80),
                    // TextInput::make('exchange_rate_notes')->label(__('backend.exchange_rate_notes'))->maxLength(80),
                ])
                ->columns(2),

            Repeater::make('entries_rep')
                ->table([
                    TableColumn::make(__('backend.account'))->alignment(Alignment::Start)->width('250px'),
                    TableColumn::make(__('backend.debit'))->alignment(Alignment::Start)->width('150px'),
                    TableColumn::make(__('backend.credit'))->alignment(Alignment::Start)->width('150px'),
                    TableColumn::make(__('backend.statement'))->alignment(Alignment::Start),
                ])
                ->required()
                ->relationship('entries')
                ->label(__('backend.accounts'))
                ->addActionLabel(__('backend.add_more'))
                ->columns(6)
                ->minItems(2)
                ->maxItems(30)
                ->defaultItems(2)
                ->columnSpan('full')
                ->schema([
                    Select::make('account_id')
                        ->label(__('backend.account'))
                        ->options(
                            Account::where('level_type', AccountLevelTypeEnum::Sub->value)
                                ->get()
                                ->pluck('name_balance', 'id'),
                        )
                        ->distinct()
                        ->required()
                        ->preload()
                        ->searchable()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 2,
                        ]),

                    TextInput::make('debit')
                        ->live(debounce: 1000)
                        ->minValue(0)
                        ->default(0)
                        ->numeric()
                        ->required()
                        ->extraInputAttributes(['step' => '0.01'])
                        ->afterStateUpdated(function ($state, Get $get, Set $set) {
                            if (is_numeric($state) && $state > 0) {
                                $set('credit', 0);
                            }
                        })
                        ->label(__('backend.debit')),
                    TextInput::make('credit')
                        ->live(debounce: 1000)
                        ->minValue(0)
                        ->default(0)
                        ->numeric()
                        ->required()
                        ->extraInputAttributes(['step' => '0.01'])
                        ->afterStateUpdated(function ($state, Get $get, Set $set) {
                            if (is_numeric($state) && $state > 0) {
                                $set('debit', 0);
                            }
                        })
                        ->label(__('backend.credit')),
                    TextInput::make('statement')
                        ->label(__('backend.statement'))
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 2,
                        ])
                        ->maxLength(80),
                ]), // Rep End
            Section::make()
                ->schema([
                    TextEntry::make('debit_sum_on')
                        ->label(__('backend.debit_sum'))
                        ->state(function (Get $get, Set $set) {
                            $deb_sum = collect($get('entries_rep'))->pluck('debit')->sum();
                            $set('debit_total', $deb_sum);
                            return number_format($deb_sum, 2);
                        }),
                    TextEntry::make('credit_sum_on')
                        ->label(__('backend.credit_sum'))
                        ->state(function (Get $get, Set $set) {
                            $credit_sum = collect($get('entries_rep'))->pluck('credit')->sum();
                            $set('credit_total', $credit_sum);
                            return number_format($credit_sum, 2);
                        }),
                    TextEntry::make('x')
                        ->label(__('backend.note'))
                        ->state(fn() => __('backend.debit_credit_must_be_equal'))
                        ->color('warning')
                        ->icon(Heroicon::ExclamationCircle)
                        ->iconColor('warning'),
                    Hidden::make('debit_total'),
                    Hidden::make('credit_total'),
                ])
                ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->striped()
            ->defaultSort('created_at', 'DESC')
            ->columns([
                TextColumn::make('ref_number')->label(__('#')),
                TextColumn::make('the_date')->label(__('backend.journal_date')),
                TextColumn::make('debit_total')
                    ->label(__('backend.debit_sum'))
                    ->formatStateUsing(fn($state) => number_format($state, 2)),
                TextColumn::make('credit_total')
                    ->label(__('backend.credit_sum'))
                    ->formatStateUsing(fn($state) => number_format($state, 2)),
                IconColumn::make('is_approved')->label(__('backend.approved'))->boolean(),
                TextColumn::make('statement')->label(__('backend.statement'))->wrap(),
                TextColumn::make('created_at')->label(__('backend.created_at')),
                TextColumn::make('creator.name')->label(__('backend.created_by')),
            ])
            ->filters([
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('from')->native(false)->label(__('backend.from_date')),
                        DatePicker::make('to')->native(false)->label(__('backend.to_date'))->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['to'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['from'] ?? null) {
                            $indicators['from'] = __('backend.from') . ' : ' . $data['from'];
                        }

                        if ($data['to'] ?? null) {
                            $indicators['to'] = __('backend.to') . ' : ' . $data['to'];
                        }

                        return $indicators;
                    }),
            ])
            ->filtersTriggerAction(fn(Action $action) => $action->button()->label(__('backend.filters')))
            ->recordActions([
                Action::make('approve')
                    ->label(__('backend.approve'))
                    ->hidden(fn($record) => $record->is_approved)
                    ->icon('heroicon-o-banknotes')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record, $data) {
                        // check account debit or credit
                        foreach ($record->entries as $entry) {
                            $ref = BedayaHelper::transactionReference();

                            if ($entry->account->type == 'debit' && $entry->debit > 0) {
                                $entry->account->balance += $entry->debit;
                                $entry->account->save();

                                // Transaction Log
                                $one = $entry->account->transactions()->create([
                                    'amount' => $entry->debit,
                                    'balance' => $entry->account->balance,
                                    'debit' => $entry->debit,
                                    'ref_number' => $ref,
                                    'statement' => __('backend.journal'),
                                    'notes' => $record->statement,
                                    'financial_year_id' => Setting::find(1)->financial_year_id,
                                    'exchange_rate_notes' => $record?->exchange_rate_notes,
                                    'invoice_number' => $record?->ref_number,
                                    'type' => 'debit',
                                ]);

                                $one->update([
                                    'invoice_number' => $record->ref_number,
                                    'created_at' => $record->created_at,
                                    'debit' => $entry->debit,
                                ]);
                            } elseif ($entry->account->type == 'debit' && $entry->debit == 0) {
                                $entry->account->balance -= $entry->credit;
                                $entry->account->save();

                                // Transaction Log
                                $two = $entry->account->transactions()->create([
                                    'amount' => $entry->credit,
                                    'balance' => $entry->account->balance,
                                    'credit' => $entry->credit,
                                    'ref_number' => $ref,
                                    'statement' => __('backend.journal'),
                                    'notes' => $record->statement,
                                    'financial_year_id' => Setting::find(1)->financial_year_id,
                                    'exchange_rate_notes' => $record?->exchange_rate_notes,
                                    'invoice_number' => $record?->ref_number,
                                    'type' => 'credit',
                                ]);

                                $two->update([
                                    'invoice_number' => $record->ref_number,
                                    'created_at' => $record->created_at,
                                    'credit' => $entry->credit,
                                ]);
                            } elseif ($entry->account->type == 'credit' && $entry->credit > 0) {
                                $entry->account->balance += $entry->credit;
                                $entry->account->save();

                                // Transaction Log
                                $three = $entry->account->transactions()->create([
                                    'amount' => $entry->credit,
                                    'balance' => $entry->account->balance,
                                    'ref_number' => $ref,
                                    'credit' => $entry->credit,
                                    'statement' => __('backend.journal'),
                                    'notes' => $record->statement,
                                    'financial_year_id' => Setting::find(1)->financial_year_id,
                                    'exchange_rate_notes' => $record?->exchange_rate_notes,
                                    'invoice_number' => $record?->ref_number,
                                    'type' => 'credit',
                                ]);

                                $three->update([
                                    'invoice_number' => $record->ref_number,
                                    'created_at' => $record->created_at,
                                ]);
                            } elseif ($entry->account->type == 'credit' && $entry->credit == 0) {
                                $entry->account->balance -= $entry->debit;
                                $entry->account->save();

                                // Transaction Log
                                $four = $entry->account->transactions()->create([
                                    'amount' => $entry->debit,
                                    'balance' => $entry->account->balance,
                                    'ref_number' => $ref,
                                    'debit' => $entry->debit,
                                    'statement' => __('backend.journal'),
                                    'notes' => $record->statement,
                                    'financial_year_id' => Setting::find(1)->financial_year_id,
                                    'exchange_rate_notes' => $record?->exchange_rate_notes,
                                    'invoice_number' => $record?->ref_number,
                                    'type' => 'debit',
                                ]);

                                $four->update([
                                    'invoice_number' => $record->ref_number,
                                    'created_at' => $record->created_at,
                                ]);
                            }
                        } // end loop
                        $record->is_approved = true;
                        $record->save();
                    }),
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton()->visible(fn($record) => !$record->is_approved),
                ActionGroup::make([DeleteAction::make()]),
            ])
            ->toolbarActions([]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJournals::route('/'),
            'create' => CreateJournal::route('/create'),
            'edit' => EditJournal::route('/{record}/edit'),
            'view' => ViewJournal::route('/{record}'),
        ];
    }
}
