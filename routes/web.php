<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EmailListController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('email-templates', EmailTemplateController::class);
    Route::get('/email-lists', [EmailListController::class, 'index'])->name('email-lists.index');
    Route::get('/email-lists/create', [EmailListController::class, 'create'])->name('email-lists.create');
    Route::post('/email-lists', [EmailListController::class, 'store'])->name('email-lists.store');
    Route::get('/email-lists/{emailList}', [EmailListController::class, 'show'])->name('email-lists.show');
    Route::delete('/email-lists/{emailList}', [EmailListController::class, 'destroy'])->name('email-lists.destroy');
    
    // Campaign routes
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');
    Route::post('/campaigns/preview', [CampaignController::class, 'preview'])->name('campaigns.preview');
});

require __DIR__.'/auth.php';
