<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class Checkout extends Component
{
    public $cart;
    public $initPoint;
    public $order;
    public bool $canBuy = false;

    public function mount()
    {
        $sessionKey = session('cart_session_key');
        $this->cart = $sessionKey ? Cart::with('items.product')->where('session_key', $sessionKey)->first() : null;
        if (!$this->cart || !$this->cart->items->count()) {
            abort(404, 'Carrito vacío');
        }
    }

    public function updatedInitPoint() {

    }

    public function createOrderAndPreference()
    {
        $total = $this->cart->items->sum(fn($i)=> $i->unit_price * $i->quantity);

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'total' => $total,
            'metadata' => ['session_key' => $this->cart->session_key],
        ]);

        foreach($this->cart->items as $item){
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
            ]);
        }

        MercadoPagoConfig::setAccessToken(config('services.mp.access_token'));

        $client = new PreferenceClient();

        $items = $this->cart->items->map(function($i){
            return [
                'title' => $i->product->name,
                'quantity' => (int)$i->quantity,
                'unit_price' => (float)$i->unit_price,
            ];
        })->toArray();

        $baseUrl = config('app.url');

        $preference = $client->create([
            'items' => $items,
            'external_reference' => (string)$order->id,
            'back_urls' => [
                'success' => route('payment.success'),
                'failure' => route('payment.failure'),
                'pending' => route('payment.pending'),
            ],
            'auto_return' => 'approved',
            'notification_url' => route('webhook.mercadopago'),
        ]);

        // Guardar pref id en la orden
        $order->update(['mp_preference_id' => $preference->id]);
        $this->order = $order;
        $this->initPoint = $preference->init_point;

        Log::channel('mp')->info('initPoint value: ', [$this->initPoint]);

        // optional:we need to empty the cart
        // $this->cart->items()->delete();
    }

    public function redirectToMP()
    {
        if ($this->initPoint) {
            return redirect()->away($this->initPoint);
        }
        $this->dispatch('notify', ['message' => 'No hay init_point']);
    }

    public function render()
    {
        return view("livewire.checkout");
        // return view('livewire.checkout', [
        //     'cart' => $this->cart,
        //     'order' => $this->order,
        //     'initPoint' => $this->initPoint
        // ]);
    }
}
