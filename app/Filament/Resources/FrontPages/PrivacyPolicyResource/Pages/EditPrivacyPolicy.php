<?php

namespace App\Filament\Resources\FrontPages\PrivacyPolicyResource\Pages;

use App\Filament\Resources\FrontPages\PrivacyPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrivacyPolicy extends EditRecord
{
    protected static string $resource = PrivacyPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
