@extends('layouts.app')

@section('content')

    <h1>{{ $product->name }}</h1>
    <p>${{ number_format($product->price,2) }}</p>


    <livewire:add-to-cart-button :product="$product" :isRedirect="true">
@endsection
