<?php

namespace App\Filament\Resources\Common\Settings\Pages;

use App\Filament\Resources\Common\Settings\SettingResource;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    public function getTitle(): string
    {
        return __('backend.settings');
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()->label(__('backend.action_save')),
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
