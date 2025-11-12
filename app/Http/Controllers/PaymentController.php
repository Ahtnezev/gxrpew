<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\Client\Preference\PreferenceClient;
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

    public function createPreference()
    {
        $client = new PreferenceClient();

        try {
            $preference = $client->create([
            'items' => [
                [
                    'id' => 'TE34883',
                    'title' => 'Teclado Mecánico RGB',
                    'quantity' => 1,
                    'unit_price' => 3.00,
                    'currency_id' => 'MXN',
                    'description' => 'descripcion de preuab 1',
                ],
                [
                    'id' => 'MO89489',
                    'title' => 'Mouse Gamer Inalámbrico',
                    'quantity' => 1,
                    'unit_price' => 4.00,
                    'currency_id' => 'MXN',
                    'description' => 'descripcion de preuab 2',
                ],
            ],
            'payer' => [
                'name' => 'Anya Forger',
                'email' => 'test_user_9084681330361817150@testuser.com',
            ],
            'back_urls' => [
                'success' => route('checkout.success'),
                'failure' => route('checkout.failure'),
                'pending' => route('checkout.pending'),
            ],
            'auto_return' => 'approved',
            //~ 'notification_url'
        ]);

        }
        catch (MPApiException $e) {
            dd([
                'status' => $e->getApiResponse()->getStatusCode(),
                'error' => $e->getApiResponse()->getContent(),
            ]);
        } catch (\Exception $e) {
            dd([
                'error' => $e->getMessage(),
            ]);
        }

        return redirect($preference->init_point);
    }
}
