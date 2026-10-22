<?php

namespace App\Filament\Resources\Accounting\ExpenseTypeResource\Pages;

use App\Filament\Resources\Accounting\ExpenseTypeResource;
use Packages\Accounting\Models\Account;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListExpenseTypes extends ListRecords
{
    protected static string $resource = ExpenseTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth(Width::Medium)
                ->createAnother(false)
                ->mutateDataUsing(function (array $data): array {
                    $data['slug'] = 'exp';
                    $data['type'] = 'debit';
                    $data['parent_id'] = Account::where('slug', 'acc_administrative_expenses')->first()->id;
                    return $data;
                }),
        ];
    }
}
