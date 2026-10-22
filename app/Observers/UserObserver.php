<?php

namespace App\Observers;

use App\Models\User;
use Packages\Accounting\Enum\AccountLevelTypeEnum;
use Packages\Accounting\Models\Account;

class UserObserver
{
    public function created(User $user): void
    {
        $acc = Account::create([
            'name' => $user->name,
            'currency_id' => 1,
            'level_type' => AccountLevelTypeEnum::Sub->value,
            'slug' => 'user',
            'type' => 'credit',
        ]);

        $user->account_id = $acc->id;
        $user->save();
    }
}
