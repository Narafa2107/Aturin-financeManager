<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\DashboardController; 

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/insights', [InsightController::class, 'index'])->name('insights');

    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');
    Route::get('/statistics/export/pdf', [StatisticsController::class, 'exportPdf'])->name('statistics.export.pdf');
    
    Route::get('/budget', [BudgetController::class, 'index'])->name('budget');
    Route::post('/budget', [BudgetController::class, 'store'])->name('budget.store');
    Route::post('/budget/source', [BudgetController::class, 'storeSource'])->name('budget.storeSource');
    Route::delete('/budget/{id}', [BudgetController::class, 'destroy'])->name('budget.destroy');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('transactions', TransactionController::class);
});

require __DIR__.'/auth.php';