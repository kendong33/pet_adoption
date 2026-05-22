<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard with stats
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Pet routes
Route::middleware('auth')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
        Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
        Route::get('/pets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');
        Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');
        Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');
        Route::patch('/pets/{pet}/archive', [PetController::class, 'archive'])->name('pets.archive');
        Route::patch('/pets/{pet}/unarchive', [PetController::class, 'unarchive'])->name('pets.unarchive');
        
        // Categories CRUD
        Route::resource('categories', CategoryController::class)->except(['show']);
    });

    Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
    Route::get('/pets/{pet}', [PetController::class, 'show'])->name('pets.show');
});

// Application routes (Adoption Applications)
Route::middleware('auth')->group(function () {
    // Adopter routes
    Route::get('/applications/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.my-applications');
    Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
        Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');
        Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');

        // Quick action routes
        Route::post('/applications/{application}/approve', [ApplicationController::class, 'approve'])->name('applications.approve');
        Route::post('/applications/{application}/decline', [ApplicationController::class, 'decline'])->name('applications.decline');
        Route::post('/applications/{application}/interview', [ApplicationController::class, 'interview'])->name('applications.interview');

        // History/archive route
        Route::get('/applications/history/list', [ApplicationController::class, 'history'])->name('applications.history');
    });
});

require __DIR__.'/auth.php';
