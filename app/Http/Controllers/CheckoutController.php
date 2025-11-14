<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\MercadoPagoService;
use MercadoPago\Client\Preference\PreferenceClient;

class CheckoutController extends Controller
{
    // public MercadoPagoService $mps;

    // public function __construct(MercadoPagoService $mps) {
    //     $this->mps = $mps;
    // }

    public function createPreference(MercadoPagoService $mps, $productId) {
        $product = Product::findOrFail($productId);

        $preference = $mps->createPreference($product);

        return response()->json([
            'id'=> $preference->id
        ]);
    }

    // public function create(Product $product)
    // {
    //     $client = new PreferenceClient();

    //     $preference = $client->create([
    //         'items' => [
    //             [
    //                 'id' => (string) $product->id,
    //                 'title' => $product->name,
    //                 'quantity' => 1,
    //                 'unit_price' => (float) $product->price,
    //                 'currency_id' => 'MXN'
    //             ]
    //         ],
    //         'payer' => [
    //             'email' => 'test_user_9084681330361817150@testuser.com'
    //         ],
    //         'back_urls' => [
    //             'success' => route('checkout.success'),
    //             'failure' => route('checkout.failure'),
    //             'pending' => route('checkout.pending'),
    //         ],
    //         'auto_return' => 'approved',
    //         'notification_url' => config('services.mp.notifications')
    //     ]);

    //     return response()->json([
    //         'preference_id' => $preference->id
    //     ]);
    // }

}
