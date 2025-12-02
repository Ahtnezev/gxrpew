@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="card shadow-sm" style="min-height: 500px">
        <div class="card-body">
            <div class="card-header">
                <h1 class="text-muted">{{ $product->name }}</h1>
            </div>
            <div class="card-body">
                <p class="text-muted">{{ $product->description }}</p>
                <p class="fw-semibold mt-4">${{ number_format($product->price, 2) }}</p>

                <a href="{{ $product->meli_url ?? '#' }}" target="_blank"
                class="btn btn-block btn-warning fw-semibold float-end mt-5">
                    Ver en Mercado Pago
                </a>
            </div>
        </div>
    </div>
@endsection
