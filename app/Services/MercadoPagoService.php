<?php

namespace App\Services;

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoService
{
    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(config('services.mp.access_token'));
    }

    public function createPreference($product)
    {
        $client = new PreferenceClient();

        return $client->create([
            'items' => [
                [
                    'id'          => (string) $product->id,
                    'title'       => $product->name,
                    'quantity'    => 1,
                    'unit_price'  => (float) $product->price,
                    'currency_id' => 'MXN',
                ]
            ],
            'payer' => ['email' => 'test_user_9084681330361817150@testuser.com'],
            'back_urls' => [
                'success' => route('checkout.success'),
                'failure' => route('checkout.failure'),
                'pending' => route('checkout.pending'),
            ],
            'auto_return' => 'approved',
            'notification_url' => config('services.mp.notifications')
        ]);
    }
}
