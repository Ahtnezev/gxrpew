<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\MercadoPagoService;

class CheckoutController extends Controller
{
    public function createPreference(MercadoPagoService $mp, $id) {
        $product = Product::findOrFail($id);

        return response()->json(
            $mp->createPreference($product)
        );
    }
}
