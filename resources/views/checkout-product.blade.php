@extends('layouts.app')

@section('content')

    <h1>{{ $product->name }}</h1>
    <p>${{ number_format($product->price,2) }}</p>

    <form method="POST" action="{{ route('checkout.cart') }}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <button type="submit" class="btn btn-primary">Comprar ahora</button>
    </form>

@endsection
