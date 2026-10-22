<?php

namespace App\Filament\Resources\Common\Users\Pages;

use App\Filament\Resources\Common\Users\RelationManagers\UserPaymentsManager;
use App\Filament\Resources\Common\Users\RelationManagers\UserServiceItemsManager;
use App\Filament\Resources\Common\Users\UserResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function getRelationManagers(): array
    {
        return [
            // UserServiceItemsManager::class,
            UserPaymentsManager::class,
        ];
    }
}
