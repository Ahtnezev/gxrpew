<?php

use App\Http\Controllers\MercadoLibreAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/mercadolibre', [MercadoLibreAuthController::class, 'redirect'])
    ->name('mercadolibre.auth');

Route::get('/auth/mercadolibre/callback', [MercadoLibreAuthController::class, 'callback'])
    ->name('mercadolibre.callback');
