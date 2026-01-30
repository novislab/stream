<?php

use App\Http\Controllers\ShortUrlRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::get('s/{code}', ShortUrlRedirectController::class)->name('short-url.redirect');
