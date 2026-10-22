<?php

namespace App\Filament\Resources\University\StudentCharges\RelationManagers;

use App\Filament\Resources\University\Payments\Pages\ViewPaymentInvoice;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Packages\Accounting\Models\Account;
use Packages\University\Enums\IdentityTypeEnum;
use Packages\University\Enums\PaymentShortStatusEnum;

class ChargesPaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

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
        return $schema
            ->components([
                Toggle::make('pay_full_amount')
                    ->label(__('backend.pay_full_amount'))
                    ->dehydrated(false)
                    ->live(debounce: 1000)
                    ->afterStateUpdated(
                        fn($set, RelationManager $livewire) => $set(
                            'amount',
                            $livewire->ownerRecord->payments_remaining,
                        ),
                    )
                    ->inline(false),

                TextInput::make('amount')
                    ->label(__('backend.amount'))
                    ->numeric()
                    ->required()
                    ->extraInputAttributes(['step' => '0.01'])
                    ->minValue(1)
                    ->maxValue(
                        fn(RelationManager $livewire) => $livewire->ownerRecord->net_amount -
                            $livewire->ownerRecord->payments_total,
                    ),
                FileUpload::make('attachment')
                    ->label(__('backend.attachment'))
                    ->image()
                    ->maxFiles(1)
                    ->maxSize(2000)
                    ->columnSpanFull(),
                Select::make('bank_id')
                    ->label(__('backend.bank'))
                    ->relationship('bank', 'name', fn($query) => $query->where('is_active', true))
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),

                TextInput::make('notes')->label(__('backend.notes'))->maxLength(150)->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('ref_number')
            ->columns([
                TextColumn::make('ref_number')->label(__('backend.ref_number')),
                TextColumn::make('amount')->label(__('backend.amount')),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => PaymentShortStatusEnum::tryFrom($state)->getLabel())
                    ->badge()
                    ->color(fn($state) => PaymentShortStatusEnum::tryFrom($state)->getColor())
                    ->label(__('backend.amount')),
                TextColumn::make('student_name')
                    ->getStateUsing(function ($record) {
                        return $record?->charge?->student?->name ?? $record?->student?->name;
                    })
                    ->label(__('backend.student')),
                TextColumn::make('created_at')->label(__('backend.created_at'))->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
                CreateAction::make()
                    ->modalWidth('xl')
                    ->modalHeading(__('backend.action_add') . ' ' . __('backend.payment'))
                    ->createAnother(false)
                    ->disabled(fn() => $this->getOwnerRecord()->PaymentsRemaining == 0)
                    ->after(function ($record) {
                        $record->update([
                            'user_id' => auth()->user()->id,
                        ]);
                    }),
            ])
            ->recordActions([
                //
                Action::make('approved')
                    ->label(__('backend.approve_payment'))
                    ->hidden(fn($record) => $record->status == PaymentShortStatusEnum::APPROVED->value)
                    ->icon('heroicon-o-banknotes')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => PaymentShortStatusEnum::APPROVED->value,
                        ]);
                    }),
                Action::make('print')
                    ->label(__('backend.print'))
                    ->url(fn($record) => ViewPaymentInvoice::getUrl([$record->id]))
                    ->icon(Heroicon::Printer)
                    ->button()
                    ->outlined(),
                EditAction::make()
                    ->iconButton()
                    ->hidden(fn($record) => $record->status == PaymentShortStatusEnum::APPROVED->value),
                ActionGroup::make([
                    //
                    DeleteAction::make()->hidden(
                        fn($record) => $record->status == PaymentShortStatusEnum::APPROVED->value,
                    ),
                ]),
            ])
            ->toolbarActions([]);
    }
}
