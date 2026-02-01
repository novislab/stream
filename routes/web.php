<?php

use App\Http\Controllers\ShortUrlRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('s/{code}', ShortUrlRedirectController::class)->name('short-url.redirect');
Route::livewire('/', 'pages::home')->name('home');
Route::livewire('/register', 'pages::register')->name('register');
Route::livewire('/payment', 'pages::payment')->name('payment');
