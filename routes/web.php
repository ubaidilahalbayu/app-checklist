<?php

use App\Livewire\TestCheckbox;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome');

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::view('checklist', 'checklist')
    ->middleware(['auth', 'verified'])
    ->name('checklist');

Route::get('/test', TestCheckbox::class)->name('test');
Route::view('riwayat', 'riwayat')
    ->middleware(['auth', 'verified'])
    ->name('riwayat');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
