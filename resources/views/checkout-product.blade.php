@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-12 col-md-6 col-lg-5 mx-auto">
            <img src="{{ App\Helpers\RandomImageHelper::getRandomImagePath() }}" class="img-fluid" alt="Nike Product">
            <h1>{{ $product->name }}</h1>
            <p>${{ number_format($product->price,2) }}</p>
            <div class="float-end">
                <livewire:add-to-cart-button :product="$product" :isRedirect="true">
            </div>
        </div>
    </div>
@endsection
