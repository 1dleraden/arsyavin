<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Books CRUD
Route::resource('books', BookController::class);

// Loans CRUD & Custom Actions
Route::resource('loans', LoanController::class);
Route::post('loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');
Route::get('loans/{loan}/slip', [LoanController::class, 'printSlip'])->name('loans.slip');
Route::get('reports', [LoanController::class, 'report'])->name('reports.index');
