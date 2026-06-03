<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');

    Route::get('/insights', function () {
        return view('insights.insights');
    })->name('insights');

    Route::get('/statistics', function () {
        return view('statistics.statistics');
    })->name('statistics');

    Route::get('/transactions', function () {
        return view('transactions.transactions');
    })->name('transactions');
    
    Route::get('/budget', function () {
    return view('budget.budget');
    })->name('budget');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';