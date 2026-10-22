<?php

namespace App\Filament\Resources\Common\Users\RelationManagers;

use App\Models\Setting;
use Packages\Accounting\Models\Account;
use Packages\Helpers\BedayaHelper;
use Packages\Services\Models\ServiceInvoiceItem;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserPaymentsManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('backend.payments');
    }

    public static function modelLabel(): ?string
    {
        return __('backend.payment');
    }

    protected static function getPluralModelLabel(): string
    {
        return __('backend.payments');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Repeater::make('invoice_items_rep')
                ->label(__('backend.items'))
                ->relationship('items')
                ->addActionLabel(__('backend.add_more'))
                ->minItems(1)
                ->columnSpan('full')
                ->required()
                ->itemLabel(function ($uuid, $component) {
                    static $position = 1;
                    return $position++;
                })
                ->table([
                    TableColumn::make(__('backend.service'))->alignment(Alignment::Start)->width('210px'),
                    TableColumn::make(__('backend.total'))->alignment(Alignment::Start)->width('120px'),
                    TableColumn::make(__('backend.service_percentage'))->alignment(Alignment::Start)->width('60px'),
                    TableColumn::make(__('backend.discounts'))->alignment(Alignment::Start)->width('120px'),
                    TableColumn::make(__('backend.net_total'))->alignment(Alignment::Start)->width('120px'),
                ])
                ->schema([
                    Select::make('service_invoice_item_id')
                        ->label(__('backend.service'))
                        ->distinct()
                        ->options(function (Get $get, $state) {
                            return ServiceInvoiceItem::all()->pluck('ServiceNameRef', 'id')->toArray();
                        })
                        ->preload()
                        ->searchable()
                        ->live(debounce: 1000)
                        ->afterStateUpdated(function ($get, $set, $state) {
                            $serviceTotal = ServiceInvoiceItem::find($state)?->sub_total ?? 0;
                            $set('sub_total', $serviceTotal);
                            $set(
                                'net_total',
                                $get('sub_total') * ($get('service_percentage') / 100) - (int) $get('discount'),
                            );
                        }),
                    TextInput::make('sub_total')
                        ->readOnly()
                        ->label(__('backend.total'))
                        ->numeric()
                        ->live(debounce: 1000),
                    TextInput::make('service_percentage')
                        ->label(__('backend.service_percentage'))
                        ->numeric()
                        ->required()
                        ->default(1)
                        ->live(debounce: 1000)
                        ->afterStateUpdated(function ($get, $set, $state) {
                            $set('net_total', $get('sub_total') * ($state / 100) - (int) $get('discount'));
                        }),
                    TextInput::make('discount')
                        ->label(__('backend.discounts'))
                        ->numeric()
                        ->required()
                        ->default(0)
                        ->live(debounce: 1000)
                        ->afterStateUpdated(function ($get, $set, $state) {
                            $set('net_total', $get('sub_total') * ($get('service_percentage') / 100) - (int) $state);
                        }),
                    TextInput::make('net_total')
                        ->readOnly()
                        ->label(__('backend.net_total'))
                        ->numeric()
                        ->live(debounce: 1000),
                ])
                ->addAction(function ($get, $set) {
                    $set('amount', array_sum(array_column($get('invoice_items_rep'), 'net_total')));
                }), // Rep End
            /////////////////////////////////////////
            Grid::make(3)->schema([
                TextInput::make('amount')
                    ->label(__('backend.amount'))
                    ->numeric()
                    ->readOnly()
                    ->required()
                    ->extraInputAttributes(['step' => '0.01'])
                    ->minValue(1),
                Select::make('account_from_id')
                    ->label(__('backend.pay_from'))
                    ->options(
                        fn() => Account::whereIn('slug', ['bank_account', 'safe_account'])
                            ->get()
                            ->pluck('name_balance_currency', 'id'),
                    )
                    ->default(fn(RelationManager $livewire) => $livewire->ownerRecord->account->id)
                    ->required(),
                Select::make('account_to_id')
                    ->label(__('backend.pay_to'))
                    ->default(fn(RelationManager $livewire) => $livewire->ownerRecord->account_id)
                    ->options(
                        fn(RelationManager $livewire) => $livewire->ownerRecord
                            ->account()
                            ->pluck('name', 'id')
                            ->toArray(),
                    )
                    ->required(),
                // TextInput::make('notes')->label(__('backend.notes'))->maxLength(150)->columnSpanFull(),
                Hidden::make('financial_year_id')->dehydrateStateUsing(fn() => Setting::find(1)->financial_year_id),
            ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ref_number')->label('#'),
                TextColumn::make('amount')
                    ->label(__('backend.amount'))
                    ->formatStateUsing(fn($state) => number_format($state, 2)),
                IconColumn::make('is_approved')->boolean()->label(__('backend.approved')),
                TextColumn::make('account_to.name')->label(__('backend.pay_to')),
                TextColumn::make('account_from.name')->label(__('backend.pay_from')),
                TextColumn::make('created_at')->label(__('backend.created_at')),
            ])
            ->filters([])
            ->filtersFormColumns(1)
            ->recordActions([
                Action::make('approve_payment')
                    ->label(__('backend.approve_payment'))
                    ->hidden(fn($record) => $record?->is_approved)
                    ->icon(Heroicon::Banknotes)
                    ->modalIcon(Heroicon::Banknotes)
                    ->color('warning')
                    ->requiresConfirmation()
                    ->schema([
                        TextEntry::make('user.name')->label(__('backend.employee')),
                        TextEntry::make('amount')->label(__('backend.amount')),
                        TextEntry::make('account_from.name')->label(__('backend.safe_account')),
                    ])
                    ->action(function ($record) {
                        $safe_acc = Account::where('id', $record->account_from_id)->firstOrFail();
                        $customer_acc = Account::where('id', $record->account_to_id)->firstOrFail();

                        $safe_acc->decrement('balance', (float) $record->amount);
                        $customer_acc->increment('balance', $record->amount);

                        $record->is_approved = true;
                        $record->save();

                        // Transaction Log
                        $trx_ref = BedayaHelper::transactionReference();

                        $safe_acc->transactions()->create([
                            'amount' => $record->amount,
                            'debit' => $record->amount,
                            'balance' => $safe_acc?->balance,
                            'ref_number' => $trx_ref,
                            'statement' => __('backend.withdraw'),
                            'notes' => $record->notes,
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                        ]);

                        $customer_acc->transactions()->create([
                            'amount' => $record->amount,
                            'credit' => $record->amount,
                            'balance' => $customer_acc?->balance,
                            'ref_number' => $trx_ref,
                            'statement' => __('backend.payment'),
                            'notes' => $record->notes,
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                        ]);
                    }),
                Action::make('view_payment')
                    ->label(__('backend.print'))
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->link()
                    ->url(
                        fn($record): string => route('filament.admin.resources.common.users.user-payment', [
                            'record' => $this->ownerRecord->id,
                            'payment' => $record,
                        ]),
                    ),
                // view-user-service-payment.blade
                EditAction::make()->iconButton()->slideOver()->hidden(fn($record) => $record?->is_approved),
                ActionGroup::make([DeleteAction::make()->hidden(fn($record) => $record?->is_approved)]),
            ])
            ->headerActions([
                CreateAction::make()->slideOver()->icon(Heroicon::OutlinedPlus)->label(__('backend.payment')),
            ])
            ->toolbarActions([]);
    }
}
