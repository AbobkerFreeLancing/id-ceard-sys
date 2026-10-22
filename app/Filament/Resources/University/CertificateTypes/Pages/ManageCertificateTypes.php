<?php

namespace App\Filament\Resources\University\CertificateTypes\Pages;

use App\Filament\Resources\University\CertificateTypes\CertificateTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCertificateTypes extends ManageRecords
{
    protected static string $resource = CertificateTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            CreateAction::make()->createAnother(false)->modalWidth('lg'),
        ];
    }
}
