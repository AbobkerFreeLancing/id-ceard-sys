<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api/chatxx')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        // Passenger Routes
        return '';
    });
