<?php

namespace App\Filament\Student\Resources\University\StudentPayments\Pages;

use App\Filament\Student\Resources\University\StudentPayments\StudentPaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentPayment extends CreateRecord
{
    protected static string $resource = StudentPaymentResource::class;
}
