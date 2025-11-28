<?php

namespace App\Helpers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MercadoPagoHelper {

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

}
