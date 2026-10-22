<?php

use Illuminate\Support\Facades\Route;
use Packages\IdCard\Livewire\CardVerificationScanner;

/*
|--------------------------------------------------------------------------
| ID Card Package Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/verify-card', CardVerificationScanner::class)
    ->name('idcard.scanner');

Route::get('/verify-card/{code}', function (string $code) {
    return redirect()->route('idcard.scanner', ['scannedCode' => $code]);
})->name('idcard.direct_verify');
