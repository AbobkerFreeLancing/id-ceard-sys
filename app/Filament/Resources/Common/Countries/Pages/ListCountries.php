<?php

namespace App\Filament\Resources\Common\Countries\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Common\Countries\CountryResource;
use App\Filament\Resources\Common\Countries\Widgets\CountriesOverview;

class ListCountries extends ListRecords
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            CountriesOverview::class,
        ];
    }
}
