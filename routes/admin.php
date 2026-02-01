<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::livewire('/login', 'pages::admin.login')->middleware('guest')->name('admin.login');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::livewire('/dashboard', 'pages::admin.dashboard')->name('admin.dashboard');
    Route::livewire('/visitors', 'pages::admin.visitors')->name('admin.visitors');
    Route::livewire('/short-urls', 'pages::admin.short-urls')->name('admin.short-urls');
    Route::livewire('/short-urls/{shortUrl}', 'pages::admin.short-urls.show')->name('admin.short-urls.show');
    Route::livewire('/settings', 'pages::admin.settings')->name('admin.settings');
    Route::livewire('/database', 'pages::admin.database-manager')->name('admin.database');
    Route::livewire('/profile', 'pages::admin.profile')->name('admin.profile');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.login');
    })->name('admin.logout');
});
