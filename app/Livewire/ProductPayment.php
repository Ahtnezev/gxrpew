<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class ProductPayment extends Component
{
    public Product $product;
    public ?string $preferenceId = null;

    public function mount(Product $product){
        $this->product = $product;
    }

    // Número: 4235647728025682
    // Titular: APRO
    // Fecha: 11/25
    // CVV: 123

    public function createPreference() {
        $client = new PreferenceClient();

        try {
            $preference = $client->create([
                'items' => [[
                    'id' => (string) $this->product->id,
                    'title' => $this->product->name,
                    'quantity' => 1,
                    'unit_price' => (float) $this->product->price,
                    'currency_id' => 'MXN',
                ]],
                'payer' => ['email' => 'test_user_9084681330361817150@testuser.com'],
                'back_urls' => [
                    'success' => route('checkout.success'),
                    'failure' => route('checkout.failure'),
                    'pending' => route('checkout.pending'),
                ],
                'auto_return' => 'approved',
                'notification_url' => config('services.mp.notifications')
            ]);

            // return redirect($preference->init_point);
            $this->preferenceId = $preference->id;

            $this->dispatch('render-wallet', id: $this->preferenceId, productId: $this->product->id);

        } catch (MPApiException $e) {
            dd([
                'status' => $e->getApiResponse()->getStatusCode(),
                'error' => $e->getApiResponse()->getContent(),
            ]);
        } catch (\Exception $e) {
            dd([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.product-payment');
    }
}
