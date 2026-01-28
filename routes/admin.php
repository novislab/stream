<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/login', 'pages::admin.login')->middleware('guest')->name('admin.login');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::livewire('/dashboard', 'pages::admin.dashboard')->name('admin.dashboard');
    Route::livewire('/settings', 'pages::admin.settings')->name('admin.settings');
});
