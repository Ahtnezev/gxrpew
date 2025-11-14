<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Livewire\Livewire;

// use MercadoPago\Client\User\UserClient;
// use MercadoPago\MercadoPagoConfig;

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get('/livewire/livewire.js', $handle);
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/test-mp', function () {
//     MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));
//     $client = new UserClient();
//     $user = $client->get();

//     return response()->json($user);
// });

Route::prefix('mercadopago')->group(function() {
    Route::get('/callback', [PaymentController::class, 'callback'])->name('mp.callback');

    Route::prefix('checkout')->group(function() {
        // Route::get('/', [PaymentController::class, 'createPreference'])->name('checkout.create');
        // Route::get('/', [CheckoutController::class, 'create'])->name('checkout.create');

        Route::post('/preference/{id}', [CheckoutController::class, 'createPreference'])->name('checkout.preference');

        Route::get('/success', [PaymentController::class, 'success'])->name('checkout.success');
        Route::get('/failure', [PaymentController::class, 'failure'])->name('checkout.failure');
        Route::get('/pending', [PaymentController::class, 'pending'])->name('checkout.pending');
    });
});


Route::get('/products', [ProductController::class, 'index'])->name('products.index');
