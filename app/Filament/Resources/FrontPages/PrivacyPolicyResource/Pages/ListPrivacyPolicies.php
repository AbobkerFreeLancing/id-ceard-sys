<?php

namespace App\Filament\Resources\FrontPages\PrivacyPolicyResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\FrontPages\PrivacyPolicyResource;
use App\Models\PrivacyPage;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrivacyPolicies extends ListRecords
{
    protected static string $resource = PrivacyPolicyResource::class;

    public function mount(): void
    {
        $this->redirect($this->getResource()::getUrl('edit',[PrivacyPage::first()->id]));
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
