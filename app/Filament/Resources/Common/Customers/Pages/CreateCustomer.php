<?php

namespace App\Filament\Resources\Common\Customers\Pages;

use App\Filament\Resources\Common\Customers\CustomerResource;
use App\Models\User;
use Packages\Accounting\Models\Account;
use Packages\Common\Models\Customer;
use Packages\Enum\Profile\UserTypeEnum;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'type' => UserTypeEnum::Customer->value,
                'name' => $data['name'] ?? null,
                'phone' => $data['phone'] ?? null,
                'email' => $data['email'] ?? null,
            ]);

            $data['user_id'] = $user->id;

            return Customer::create([
                'user_id' => $user->id,
                'branch_id' => Filament::getTenant()->id,
            ]);
        });
    }

    public function canCreateAnother(): bool
    {
        return false;
    }
}
