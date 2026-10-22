<?php

namespace App\Filament\Resources\University\CertificateRequests\Pages;

use App\Filament\Resources\University\CertificateRequests\CertificateRequestResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCertificateRequest extends EditRecord
{
    protected static string $resource = CertificateRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
