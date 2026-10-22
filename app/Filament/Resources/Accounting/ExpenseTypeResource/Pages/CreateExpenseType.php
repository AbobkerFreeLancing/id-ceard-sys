<?php

namespace App\Filament\Resources\Accounting\ExpenseTypeResource\Pages;

use App\Filament\Resources\Accounting\ExpenseTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExpenseType extends CreateRecord
{
    protected static string $resource = ExpenseTypeResource::class;
}
