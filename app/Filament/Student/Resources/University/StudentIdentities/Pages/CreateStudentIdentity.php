<?php

namespace App\Filament\Student\Resources\University\StudentIdentities\Pages;

use App\Filament\Student\Resources\University\StudentIdentities\StudentIdentityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentIdentity extends CreateRecord
{
    protected static string $resource = StudentIdentityResource::class;
}
