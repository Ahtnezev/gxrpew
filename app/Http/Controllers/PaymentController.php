<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\Client\Payment\PaymentClient;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        dd(
            $request->all()
        );
    }

    public function success(Request $request) {
        $paymentId = $request->get('payment_id');

        if (!$paymentId) {
            return redirect()->route('home')->with('error', 'No se recibió el ID del pago.');
        }

        $client = new PaymentClient();

        try {
            $payment = $client->get($paymentId);

            // Order::where('external_reference', $payment->external_reference)
            //     ->update(['status' => $payment->status]);

            return view('checkout.success', [
                'payment' => $payment,
                'status' => $payment->status,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error al obtener el pago: ' . $e->getMessage());
        }
    }

    public function pending(Request $request) {
        return view('checkout.pending');
    }

    public function failure(Request $request) {
        return view('checkout.failure');
    }

}
