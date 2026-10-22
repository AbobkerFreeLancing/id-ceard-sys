<?php

namespace App\Filament\Resources\Common\Settings\Pages;

use App\Filament\Resources\Common\Settings\SettingResource;
use App\Models\Setting;
use Filament\Resources\Pages\ListRecords;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    public function mount(): void
    {
        $this->redirect(SettingResource::getUrl('edit', [Setting::first()]));
    }

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
