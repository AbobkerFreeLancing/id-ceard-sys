<?php

namespace App\Filament\Resources\Accounting\JournalResource\Pages;

use App\Models\Setting;
use Packages\Helpers\BedayaHelper;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Accounting\JournalResource;

class ViewJournal extends ViewRecord
{
    protected static string $resource = JournalResource::class;
    protected string $view = 'bedaya:accounting::view-journal';

    public $print_auto = '';

    protected $queryString = [
        'print_auto',
    ];

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label(__('backend.approve'))
                ->hidden(fn ($record) => $record->is_approved)
                ->icon('heroicon-o-banknotes')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function ($record, $data){
                    // check account debit or credit
                    foreach ($record->entries as $entry) {

                        $ref = BedayaHelper::transactionReference();

                        if($entry->account->type == "debit" && $entry->debit > 0) {
                            $entry->account->balance +=  $entry->debit;
                            $entry->account->save();

                            // Transaction Log
                            $entry->account->transactions()->create([
                            'amount' => $entry->debit,
                            'balance' =>  $entry->account->balance,
                            'credit' => $entry->credit,
                            'debit' => $entry->debit,
                            'ref_number' => $ref,
                            'statement' => __('backend.journal'),
                            'notes' => $record->statement,
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                            'type' => 'debit',
                            'exchange_rate_notes' => $record->exchange_rate_notes
                            ]);
                        }

                        elseif($entry->account->type == "debit" && $entry->debit == 0) {
                            $entry->account->balance -=  $entry->credit;
                            $entry->account->save();

                            // Transaction Log
                            $entry->account->transactions()->create([
                            'amount' => $entry->credit,
                            'balance' =>  $entry->account->balance,
                            'credit' => $entry->credit,
                            'debit' => $entry->debit,
                            'ref_number' => $ref,
                            'statement' => __('backend.journal'),
                            'notes' => $record->statement,
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                            'type' => 'credit',
                            'exchange_rate_notes' => $record->exchange_rate_notes
                            ]);
                        }

                        elseif($entry->account->type == "credit" && $entry->credit > 0) {
                            $entry->account->balance +=  $entry->credit;
                            $entry->account->save();

                            // Transaction Log
                            $entry->account->transactions()->create([
                            'amount' => $entry->credit,
                            'balance' =>  $entry->account->balance,
                            'credit' => $entry->credit,
                            'debit' => $entry->debit,
                            'ref_number' => $ref,
                            'statement' => __('backend.journal'),
                            'notes' => $record->statement,
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                            'type' => 'credit',
                            'exchange_rate_notes' => $record->exchange_rate_notes
                            ]);
                        }

                        elseif($entry->account->type == "credit" && $entry->credit == 0) {
                            $entry->account->balance -=  $entry->debit;
                            $entry->account->save();

                            // Transaction Log
                            $entry->account->transactions()->create([
                            'amount' => $entry->debit,
                            'balance' =>  $entry->account->balance,
                            'credit' => $entry->credit,
                            'debit' => $entry->debit,
                            'ref_number' => $ref,
                            'statement' => __('backend.journal'),
                            'notes' => $record->statement,
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                            'type' => 'debit',
                            'exchange_rate_notes' => $record->exchange_rate_notes
                            ]);
                        }

                    } // end loop
                    $record->is_approved = true;
                    $record->save();
                }),
             EditAction::make('edit')->label(__("backend.action_edit"))
             ->color('success')->hidden(fn ($record) => $record->is_approved),

             Action::make('print')->label(__('backend.print'))->color('warning')
             ->icon('heroicon-o-printer')->action(function () {
                $this->js("window.print()");
            }),
        ];
    }

}
