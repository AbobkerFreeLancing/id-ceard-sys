<?php

use Packages\DocsModule\Livewire\DocsProjecDetails;
use Illuminate\Support\Facades\Route;

/* Docs Routes */

Route::prefix('dev/docs')->group(function () {
    Route::get('/{project:slug}', DocsProjecDetails::class)->name('docs_project');
});
