<?php

namespace App\Filament\Admin\Resources\VerificationLogs\Pages;

use App\Filament\Admin\Resources\VerificationLogs\VerificationLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVerificationLog extends CreateRecord
{
    protected static string $resource = VerificationLogResource::class;
}
