<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreditController;

// Logowanie i wylogowanie
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Kalkulator – tylko dla zalogowanych użytkowników
Route::middleware('check.auth')->group(function () {
    Route::match(['get', 'post'], '/', [CreditController::class, 'credit'])->name('credit');
});