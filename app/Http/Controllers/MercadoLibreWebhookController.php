<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MercadoLibreWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info("Webhook MP: ", $request->all());
        return $request->all();
    }
}
