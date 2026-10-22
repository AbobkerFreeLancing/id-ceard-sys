<?php

namespace App\Filament\Resources\Accounting\Safes\Pages;

use App\Filament\Resources\Accounting\Safes\SafeResource;
use Packages\Accounting\Models\Account;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSafes extends ListRecords
{
    protected static string $resource = SafeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->mutateDataUsing(function (array $data) {
                $data['parent_id'] = Account::where('slug', 'current_assets')->first()->id;
                $data['slug'] = 'safe_account';
                return $data;
            }),
        ];
    }
}
