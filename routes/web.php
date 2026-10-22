<?php

use App\Livewire\Pages\HomePage;
use Illuminate\Support\Facades\Route;

/* Web Routes */

Route::get('/', HomePage::class)->name('home');

