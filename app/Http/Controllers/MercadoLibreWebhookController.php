<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MercadoLibreWebhookController extends Controller
{
    public function handle(Request $request)
    {
        return $request->all();
    }
}
