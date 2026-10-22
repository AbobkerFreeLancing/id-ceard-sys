<?php

namespace App\Filament\Resources\University\CertificateRequests\Pages;

use App\Filament\Resources\University\CertificateRequests\CertificateRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCertificateRequest extends ViewRecord
{
    protected static string $resource = CertificateRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
