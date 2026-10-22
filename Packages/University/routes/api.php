<?php

use Illuminate\Support\Facades\Route;
use Packages\University\Controllers\API\v1\Student\StudentLoginApiController;
use Packages\University\Controllers\API\v1\StudentInvoiceApiController;

// Get Invoice By ref_number
Route::post('student/get-invoice-by-ref', [StudentInvoiceApiController::class, 'getInvoiceByRefernce']);
Route::post('student/pay-invoice-by-ref', [StudentInvoiceApiController::class, 'payInvoiceByRefernce']);

// Invoices By university_no
Route::post('student/get-invoices-by-university-no', [
    StudentInvoiceApiController::class,
    'getInvoicesByUniversityNumber',
]);
Route::post('student/pay-invoices-by-university-no', [
    StudentInvoiceApiController::class,
    'payInvoicesByUniversityNumber',
]);

// ==========================================

// Student Auth Routes
Route::middleware(['cors_api'])
    ->prefix('student')
    ->group(function () {
        Route::post('login', StudentLoginApiController::class);
    });
