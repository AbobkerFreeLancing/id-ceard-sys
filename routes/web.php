<?php

use App\Livewire\Cardholders\CardholderDirectory;
use App\Livewire\Cards\VerifyCard;
use App\Livewire\PortalHome;
use App\Livewire\Reissues\TrackReissue;
use Illuminate\Support\Facades\Route;

Route::get('/', PortalHome::class)->name('home');
Route::get('/verify/{uid?}', VerifyCard::class)->name('cards.verify');
Route::get('/cardholders', CardholderDirectory::class)->name('cardholders.directory');
Route::get('/track-reissue', TrackReissue::class)->name('reissues.track');
