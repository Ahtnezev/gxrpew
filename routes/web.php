<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
// use MercadoPago\Client\User\UserClient;
// use MercadoPago\MercadoPagoConfig;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/test-mp', function () {
//     MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));
//     $client = new UserClient();
//     $user = $client->get();

//     return response()->json($user);
// });

// Route::prefix('mercadolibre')->group(function() {
//     Route::get('/callback', [MercadoLibreController::class, 'callback'])->name('mercadolibre.callback');
//     Route::get('/login', [MercadoLibreController::class, 'redirectToAuth'])->name('mercadolibre.login');
//     Route::get('/account', [MercadoLibreController::class, 'account'])->name('mercadolibre.account');
// });

Route::prefix('mercadopago')->group(function() {
    Route::get('/callback', [PaymentController::class, 'callback'])->name('mp.callback');

    Route::prefix('checkout')->group(function() {
        Route::get('/', [PaymentController::class, 'createPreference'])->name('checkout.create');

        Route::get('/success', [PaymentController::class, 'success'])->name('checkout.success');
        Route::get('/failure', [PaymentController::class, 'failure'])->name('checkout.failure');
        Route::get('/pending', [PaymentController::class, 'pending'])->name('checkout.pending');
    });
});



Route::resource('products', ProductController::class);

