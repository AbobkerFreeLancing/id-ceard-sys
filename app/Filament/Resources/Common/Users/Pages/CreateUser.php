<?php

namespace App\Filament\Resources\Common\Users\Pages;

use App\Filament\Resources\Common\Users\UserResource;
use App\Models\Setting;
use Packages\Accounting\Enum\AccountLevelTypeEnum;
use Packages\Accounting\Models\Account;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function canCreateAnother(): bool
    {
        return false;
    }
}
