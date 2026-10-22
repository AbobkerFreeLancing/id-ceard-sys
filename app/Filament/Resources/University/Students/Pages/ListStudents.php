<?php

namespace App\Filament\Resources\University\Students\Pages;

use App\Filament\Resources\University\Students\StudentResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    public function hasResourceBreadcrumbs(): bool
    {
        return false;
    }

    public function getBreadcrumb(): ?string
    {
        return null;
    }

    public function getSubheading(): ?string
    {
        return __('يتم عرض أحدث 10 طلاب مضافين');
    }

    protected function getHeaderActions(): array
    {
        return [
            //
            CreateAction::make(),
        ];
    }
}
