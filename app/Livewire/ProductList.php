<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function render()
    {
        return view('livewire.product-list', [
            'products' => Product::paginate(3)
        ]);
    }

    public function addToCart(Product $product, $qty = 1)
    {
        $sessionKey = session()->get('cart_session_key', Str::uuid()->toString());
        session(['cart_session_key' => $sessionKey]);

        $cart = Cart::firstOrCreate(
            ['session_key' => $sessionKey],
            ['user_id' => Auth::id()]
        );

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('quantity', $qty);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $qty,
                'unit_price' => $product->price,
            ]);
        }

        $this->dispatch('cart-component', 'cartUpdated'); // notifica al componente cart
        $this->dispatch('notify', ['message' => 'Producto añadido']);
    }

    //~ it works
    // public function buy($productId)
    // {
    //     $this->dispatch('request-preference', productId: $productId);
    // }

}
