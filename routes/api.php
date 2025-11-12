<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MercadoLibreWebhookController;

Route::prefix('/webhooks/test/mercadolibre')->group(function () {
    Route::post('/', [MercadoLibreWebhookController::class, 'handle'])
        ->name('webhooks.mercadolibre');
    Route::post('/orders', [MercadoLibreWebhookController::class, 'handleOrders']);
    Route::post('/payments', [MercadoLibreWebhookController::class, 'handlePayments']);
    Route::post('/shipments', [MercadoLibreWebhookController::class, 'handleShipments']);
});

// https://<domain>/api/webhooks/mercadolibre
