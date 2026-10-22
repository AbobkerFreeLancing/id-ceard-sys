<?php

namespace App\Filament\Resources\University\CertificateRequests\Pages;

use App\Filament\Resources\University\CertificateRequests\CertificateRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCertificateRequests extends ListRecords
{
    protected static string $resource = CertificateRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
