<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MercadoPagoService
{
    protected $secretKey;
    protected $url = "https://api.mercadopago.com/checkout/preferences";

    public function __construct()
    {
        $this->secretKey = config('services.mp.access_token');
    }

    /**
     *
    */
    public static function addToCart(Product $product, String $sessionKey, int $qty): CartItem|Cart
    {
        $cart = Cart::firstOrCreate(
            ['session_key' => $sessionKey],
            ['user_id' => Auth::id()]
        );

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('quantity', $qty);
            return $item;
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $qty,
                'unit_price' => $product->price,
            ]);
            return $cart;
        }
    }


    public function createPreference($product)
    {
        $payload = [
            "items" => [
                [
                    "title"       => $product->name,
                    "quantity"    => 1,
                    "unit_price"  => (float) $product->price,
                    "currency_id" => "MXN",
                ]
            ],
            "back_urls" => [
                "success" => route('payment.success'),
                "failure" => route('payment.failure'),
            ]
        ];

        $response = Http::withToken($this->secretKey)
            ->post($this->url, $payload);

        return $response->json();

        // $client = new PreferenceClient();

        // return $client->create([
        //     'items' => [
        //         [
        //             'id'          => (string) $product->id,
        //             'title'       => $product->name,
        //             'quantity'    => 1,
        //             'unit_price'  => (float) $product->price,
        //             'currency_id' => 'MXN',
        //         ]
        //     ],
        //     'payer' => ['email' => 'test_user_9084681330361817150@testuser.com'],
        //     'back_urls' => [
        //         'success' => route('checkout.success'),
        //         'failure' => route('checkout.failure'),
        //         'pending' => route('checkout.pending'),
        //     ],
        //     'auto_return' => 'approved',
        //     'notification_url' => config('services.mp.notifications')
        // ]);
    }
}
