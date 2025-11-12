<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MercadoLibreWebhookController;

Route::post('/webhooks/test/mercadopago', [MercadoLibreWebhookController::class, 'handle'])->name('webhooks.mercadolibre');

Route::prefix('/webhooks/test/mercadopago')->group(function () {
    Route::post('/orders', [MercadoLibreWebhookController::class, 'handleOrders']);
    Route::post('/payments', [MercadoLibreWebhookController::class, 'handlePayments']);
    Route::post('/shipments', [MercadoLibreWebhookController::class, 'handleShipments']);
});

// https://<domain>/api/webhooks/mercadolibre
