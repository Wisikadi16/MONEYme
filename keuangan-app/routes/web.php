<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionTemplateController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::post('/transactions/quick', [TransactionController::class, 'quickAction'])->name('transactions.quick');

Route::get('/templates', [TransactionTemplateController::class, 'index'])->name('templates.index');
Route::post('/templates', [TransactionTemplateController::class, 'store'])->name('templates.store');
Route::delete('/templates/{template}', [TransactionTemplateController::class, 'destroy'])->name('templates.destroy');
