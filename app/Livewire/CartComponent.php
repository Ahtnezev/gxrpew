<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;

class CartComponent extends Component
{
    public $cart;

    protected $listeners = ['cartUpdated' => 'load'];

    public function mount() { $this->load(); }

    public function load() {
        $sessionKey = session('cart_session_key');
        $this->cart = $sessionKey ? Cart::with('items.product')->where('session_key', $sessionKey)->first() : null;
    }

    public function removeItem($id) {
        $item = \App\Models\CartItem::find($id);
        if ($item) $item->delete();
        $this->load();
        $this->dispatch('cartUpdated');
    }

    public function updateQty($id, $qty) {
        $item = \App\Models\CartItem::find($id);
        if (empty($qty)) {
            $qty = 1;
        }
        if ($item && $qty > 0) {
            $item->update(['quantity' => (int)$qty]);
        }
        $this->load();
    }

    public function render()
    {
        return view('livewire.cart-component');
    }
}
