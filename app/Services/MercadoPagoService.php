<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoService
{
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = config('services.mp.access_token');
    }

    public function createPreference($product)
    {
        $url = "https://api.mercadopago.com/checkout/preferences";

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
                "success" => route('checkout.success'),
                "failure" => route('checkout.failure'),
            ]
        ];

        $response = Http::withToken($this->secretKey)
            ->post($url, $payload);

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
