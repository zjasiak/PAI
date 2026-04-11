<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreditController;

// Główna strona aplikacji – kalkulator kredytowy
Route::match(['get', 'post'], '/', [CreditController::class, 'credit'])->name('credit');