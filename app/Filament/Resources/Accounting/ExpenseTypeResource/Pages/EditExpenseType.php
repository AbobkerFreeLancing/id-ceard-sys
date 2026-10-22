<?php

namespace App\Filament\Resources\Accounting\ExpenseTypeResource\Pages;

use App\Filament\Resources\Accounting\ExpenseTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpenseType extends EditRecord
{
    protected static string $resource = ExpenseTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
