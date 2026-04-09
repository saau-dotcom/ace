<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LeadCommandCenter;
use App\Livewire\QuoteBuilder;
use App\Livewire\InstallerJobView;

// Redirect homepage to login
Route::get('/', function () {
    return redirect('/login');
});

// Protect our CRM routes so only logged-in employees can access them
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', App\Livewire\AdminDashboard::class)->name('dashboard');
    Route::get('/leads', App\Livewire\AdminLeadsManager::class)->name('leads.index');
    Route::get('/leads/{lead}', App\Livewire\LeadCommandCenter::class)->name('leads.show');
    // Quotes Manager Removed
    Route::get('/settings', App\Livewire\SettingsManager::class)->name('settings.index');
    Route::get('/jobs', App\Livewire\InstallerJobs::class)->name('jobs.index');
});

// Loads the Laravel Breeze login/logout routes
require __DIR__.'/auth.php';