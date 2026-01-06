<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\MercadoPagoService;
use Illuminate\Support\Str;
use Livewire\Component;
use SweetAlert2\Laravel\Traits\WithSweetAlert;

class AddToCartButton extends Component
{
    use WithSweetAlert;

    public ?Product $product = null;
    public bool $isRedirect = false;

    public function mount(?Product $product) {
        $this->product = $product;
    }

    public function addToCart(Product $product, int $qty = 1)
    {
        $sessionKey = session()->get('cart_session_key', Str::uuid()->toString());
        session(['cart_session_key' => $sessionKey]);

        MercadoPagoService::addToCart($product, $sessionKey, $qty);

        $this->dispatch('cart-component', 'cartUpdated'); // notificar al componente cart: CartComponent
        // $this->dispatch('notify', ['id' => $product->id, 'message' => 'Producto añadido']);
        $this->swalToast([
            'title' => 'Producto añadido al carrito',
            'text' => Str::limit($product->name, 15, '...'),
            'position' => 'top-end',
            'icon' => 'success',
            'showConfirmButton' => false,
            'timer' => 2000,
        ]);
        if ($this->isRedirect) {
            return redirect()->route('cart.index');
        }
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}
