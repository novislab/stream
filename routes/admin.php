<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/dashboard', 'pages::admin.dashboard')->name('admin.dashboard');
Route::livewire('/login', 'pages::admin.login')->name('admin.login');
Route::livewire('/settings', 'pages::admin.settings')->name('admin.settings');
