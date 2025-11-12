@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1>✅ Pago exitoso</h1>
    <p>Gracias por tu compra.</p>
    <p><strong>Estado:</strong> {{ $status }}</p>
    <p><strong>ID de pago:</strong> {{ $payment->id }}</p>
    <p><strong>Monto:</strong> ${{ number_format($payment->transaction_amount, 2) }}</p>
</div>
@endsection
