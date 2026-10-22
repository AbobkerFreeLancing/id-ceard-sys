<?php

use App\Livewire\Pages\HomePage;
use Illuminate\Support\Facades\Route;

/* Web Routes */

Route::get('/', HomePage::class)->name('home');

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/admin/student-interviews/print-report', [\App\Http\Controllers\StudentInterviewReportController::class, 'printReport'])
        ->name('student-interviews.print-report');
    Route::get('/admin/student-interviews/{record}/print-card', [\App\Http\Controllers\StudentInterviewReportController::class, 'printCard'])
        ->name('student-interviews.print-card');
});
