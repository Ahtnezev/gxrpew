<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MercadoPagoWebhookController;
use App\Livewire\Checkout;


//* #2
Route::get('/', App\Livewire\ProductList::class)->name('products.index');


Route::get('/cart', function () {
    return view('cart');
})->name('cart.index');


Route::get('/checkout/cart', Checkout::class)->name('checkout.cart');


Route::get('/checkout/{product}', function(\App\Models\Product $product){
    return view('checkout-product', compact('product'));
})->name('checkout.show');


Route::get('/payment/success', function() { return view('payments.success'); })->name('payment.success');
Route::get('/payment/failure', function() { return view('payments.failure'); })->name('payment.failure');
Route::get('/payment/pending', function() { return view('payments.pending'); })->name('payment.pending');


// Webhook (POST)
Route::post('/webhooks/test/mercadopago', [MercadoPagoWebhookController::class, 'handle'])->name('webhook.mercadopago');


//* #1
// Route::post('/checkout/preference/{product}', [CheckoutController::class, 'createPreference'])
//     ->name('checkout.preference');



// Route::prefix('mercadopago')->group(function() {
//     Route::get('/callback', [PaymentController::class, 'callback'])->name('mp.callback');

//     Route::prefix('checkout')->group(function() {
//         Route::get('/success', [PaymentController::class, 'success'])->name('checkout.success');
//         Route::get('/failure', [PaymentController::class, 'failure'])->name('checkout.failure');
//         Route::get('/pending', [PaymentController::class, 'pending'])->name('checkout.pending');
//     });
// });
