<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use MercadoPagoHelper;

class ProductList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function render()
    {
        return view('livewire.product-list', [
            'products' => Product::paginate(9)
        ]);
    }

    public function addToCart(Product $product, $qty = 1)
    {
        // $sessionKey = session()->get('cart_session_key', Str::uuid()->toString());
        // session(['cart_session_key' => $sessionKey]);

        // $cart = MercadoPagoHelper::addToCart($product, $sessionKey);

        $this->dispatch('cart-component', 'cartUpdated'); // notificar al componente cart
        $this->dispatch('notify', ['message' => 'Producto añadido']);
    }

    //~ it works
    // public function buy($productId)
    // {
    //     $this->dispatch('request-preference', productId: $productId);
    // }

}
