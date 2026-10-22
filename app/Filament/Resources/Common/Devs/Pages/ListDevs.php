<?php

namespace App\Filament\Resources\Common\Devs\Pages;

use App\Filament\Resources\Common\Devs\DevResource;
use Packages\Common\Models\Dev;
use Filament\Resources\Pages\ListRecords;

class ListDevs extends ListRecords
{
    public function mount(): void
    {
        Dev::first() == null
            ? Dev::create([
                'admin_color_hex' => '#eb314e',
            ])
            : null;
        redirect(DevResource::getUrl('edit', [Dev::first()->id]));
    }

    protected static string $resource = DevResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
