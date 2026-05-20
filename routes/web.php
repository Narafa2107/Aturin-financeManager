<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'auth.login')->name('login');

Route::view('/register', 'auth.register')->name('register');

Route::view('/dashboard', 'dashboard.dashboard')->name('dashboard');

Route::view('/transactions', 'transactions.transactions')->name('transactions');

Route::view('/statistics', 'statistics.statistics')->name('statistics');

Route::view('/budget', 'budget.budget')->name('budget');
Route::view('/insights', 'insights.insights')->name('insights');
