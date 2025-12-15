<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MercadoPagoWebhookController extends Controller
{

    public function handle(Request $request)
    {
        if (!$request->isMethod('post')) {
            return response()->json(['error' => 'Método no permitido'], 405);
        }

        $signature = $request->header('x-signature');
        $id = $request->header('x-request-id');
        $data = $request->all();

        Log::channel('mp')->info('Webhook MercadoPago recibido', [
            'signature' => $signature,
            'request_id' => $id,
            'data' => $data
        ]);

        $isValid = $this->validateWebhook($request);

        if (!$isValid) {
            Log::channel('mp')->warning('Webhook MercadoPago inválido', [
                'request_id' => $id,
                'ip' => $request->ip()
            ]);
            return response()->json(['error' => 'Webhook inválido'], 401);
        }

        return $this->processWebhook($data);
    }


    private function validateWebhook(Request $request): bool
    {
        try {
            $signature = $request->header('x-signature');

            if (!$signature) {
                Log::channel('mp')->error('Falta header x-signature');
                return false;
            }

            $accessToken = config('services.mp.webhooks_access_token');

            if (!$accessToken) {
                Log::channel('mp')->error('Access token de MercadoPago no configurado');
                return false;
            }

            $parts = explode(',', $signature);
            $ts = null;
            $hash = null;

            foreach ($parts as $part) {
                if (strpos($part, 'ts=') === 0) {
                    $ts = substr($part, 3);
                } elseif (strpos($part, 'v1=') === 0) {
                    $hash = substr($part, 3);
                }
            }

            if (!$ts || !$hash) {
                Log::channel('mp')->error('Firma mal formada', ['signature' => $signature]);
                return false;
            }

            $requestBody = $request->getContent();
            $manifest = "id:{$request->header('x-request-id')};request-id:{$request->header('x-request-id')};ts:{$ts};";

            // Calcular el hash esperado
            $expectedHash = hash_hmac('sha256', $manifest . $requestBody, $accessToken);

            return hash_equals($hash, $expectedHash);

        } catch (\Exception $e) {
            Log::channel('mp')->error('Error validando webhook MercadoPago: ' . $e->getMessage());
            return false;
        }
    }

    private function processWebhook(array $data)
    {
        try {
            $type = $data['type'] ?? null;
            $action = $data['action'] ?? null;
            $dataId = $data['data']['id'] ?? null;

            Log::channel('mp')->info('Procesando webhook MercadoPago', [
                'type' => $type,
                'action' => $action,
                'data_id' => $dataId
            ]);

            switch ($type) {
                case 'payment':
                    $this->processPayment($dataId);
                    break;
                default:
                    Log::channel('mp')->warning('Tipo de webhook no manejado', ['type' => $type]);
            }

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            Log::channel('mp')->error('Error procesando webhook: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno'], 500);
        }
    }


    private function processPayment($paymentId)
    {
        Log::channel('mp')->info('Procesando pago: ' . $paymentId);

        // Ejemplo: Actualizar estado del pago en tu base de datos
        // Payment::where('mp_payment_id', $paymentId)->update(['status' => 'completed']);
    }


    // public function handle(Request $request)
    // {
    //     // Mercado Pago puede enviar diferentes payloads. Lo más seguro es:
    //     // 1) Obtener payment_id desde request (MP puede enviar 'id' o topic + id)
    //     // 2) Consultar la API de MP para obtener estado real del pago
    //     // 3) Actualizar la orden según external_reference o preference_id

    //     Log::channel('mp')->info('MP webhook payload: ' . json_encode($request->all()));

    //     // Try to find payment id
    //     // $mpId = $request->input('id') ?? $request->input('data.id') ?? $request->input('data')['id'] ?? null;
    //     // $topic = $request->input('topic') ?? $request->input('type') ?? null;

    //     // if (!$mpId) {
    //     //     return response()->json(['ok' => true], 200);
    //     // }

    //     // $accessToken = config('services.mp.access_token');
    //     // $url = config('app.url');
    //     // // Consultar la API de Mercado Pago
    //     // $response = Http::withToken($accessToken)
    //     //     ->get("https://api.mercadopago.com/v1/payments/{$mpId}");

    //     // if (!$response->successful()) {
    //     //     Log::error("MP fetch payment failed: {$response->body()}");
    //     //     return response()->json(['ok' => false], 500);
    //     // }

    //     // $payment = $response->json();

    //     // // Estructura: buscar external_reference en payment -> preference_id or external_reference
    //     // $externalReference = $payment['external_reference'] ?? null;
    //     // $preferenceId = $payment['order'] ?? null;
    //     // // Mercado Pago v1 payment has 'order' or 'external_reference' sometimes — revisa payload real.

    //     // // Fallback: try to find order by mp_preference_id matching 'preference_id' or mp_preference_id in payment->preference_id
    //     // $mpPref = $payment['preference_id'] ?? $payment['order']['id'] ?? null;
    //     // $order = null;

    //     // if ($externalReference) {
    //     //     $order = Order::find($externalReference);
    //     // }

    //     // if (!$order && $mpPref) {
    //     //     $order = Order::where('mp_preference_id', $mpPref)->first();
    //     // }

    //     // // If still not found, search by external_reference found inside 'metadata' or 'order'
    //     // if (!$order) {
    //     //     // Try other heuristics
    //     //     $order = Order::where('mp_preference_id', $payment['preference_id'] ?? '')->first();
    //     // }

    //     // if (!$order) {
    //     //     Log::warning("Order not found for MP payment {$mpId}");
    //     //     return response()->json(['ok' => true], 200);
    //     // }

    //     // // Map MP statuses to our order statuses
    //     // // payment['status'] may be 'approved', 'pending', 'rejected'
    //     // $status = $payment['status'] ?? null;
    //     // $paymentStatus = strtolower($status);

    //     // if ($paymentStatus === 'approved') {
    //     //     $order->update(['status' => 'paid']);
    //     //     // crear lógica para marcar stock, enviar mail, crear factura, etc.
    //     // } elseif ($paymentStatus === 'pending') {
    //     //     $order->update(['status' => 'pending']);
    //     // } else {
    //     //     $order->update(['status' => 'failed']);
    //     // }

    //     // Log::info("Order {$order->id} updated by MP webhook. status: {$order->status}");

    //     // return response()->json(['ok' => true], 200);
    // }
}
