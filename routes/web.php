<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MercadoPagoWebhookController;
use App\Livewire\Checkout;


Route::get('/', App\Livewire\ProductList::class)
    ->name('home');

Route::get('/checkout/cart', Checkout::class)
    ->name('checkout.cart');

Route::get('/cart', fn() => view('cart'))
    ->name('cart.index');

Route::get('/checkout/{product}', fn(\App\Models\Product $product) => view('checkout-product', compact('product')))
    ->name('checkout.show');

Route::get('/payment/success', fn() => view('payments.success'))->name('payment.success');
Route::get('/payment/failure', fn() => view('payments.failure'))->name('payment.failure');
Route::get('/payment/pending', fn() => view('payments.pending'))->name('payment.pending');


//? Webhook (POST)
Route::post('/webhooks/v1/test/mercadopago', [MercadoPagoWebhookController::class, 'handle'])
    ->name('webhook.mercadopago');
