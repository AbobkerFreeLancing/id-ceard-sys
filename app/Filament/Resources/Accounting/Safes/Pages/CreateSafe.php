<?php

namespace App\Filament\Resources\Accounting\Safes\Pages;

use App\Filament\Resources\Accounting\Safes\SafeResource;
use App\Models\Setting;
use Packages\Accounting\Enum\AccountLevelTypeEnum;
use Packages\Accounting\Models\Account;
use Packages\Helpers\BedayaHelper;
use Filament\Resources\Pages\CreateRecord;

class CreateSafe extends CreateRecord
{
    protected static string $resource = SafeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $this->record->slug = 'safe_account';
        $this->record->type = 'debit';
        $this->record->level_type = AccountLevelTypeEnum::Sub->value;
        $this->record->balance += $this->record->start_balance;
        $this->record->parent_id = Account::where('slug', 'acc_cash')->first()->id;
        $this->record->code = $this->record->parent->code . ($this->record->parent->children()->count() + 1);
        $this->record->save();

        if ($this->record->start_balance <= 0) {
            return;
        }

        $ref = BedayaHelper::transactionReference();

        $this->record->transactions()->create([
            'amount' => $this->record->balance,
            'debit' => $this->record->balance,
            'balance' => $this->record->balance,
            'ref_number' => $ref,
            'statement' => __('backend.start_balance'),
            'financial_year_id' => Setting::find(1)->financial_year_id,
        ]);
    }

    public function canCreateAnother(): bool
    {
        return false;
    }
}
