<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MercadoLibreController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mercadolibre/callback', [MercadoLibreController::class, 'callback'])->name('mercadolibre.callback');
Route::get('/mercadolibre/login', [MercadoLibreController::class, 'redirectToAuth'])->name('mercadolibre.login');
Route::get('/mercadolibre/account', [MercadoLibreController::class, 'account'])->name('mercadolibre.account');

