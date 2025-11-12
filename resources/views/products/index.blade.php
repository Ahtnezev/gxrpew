@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <h1 class="fw-bold display-5 mb-5">Nuestros Productos</h1>

    <div class="d-flex align-items-center justify-content-start flex-wrap">
        @foreach($products as $product)
            <div class="card mb-4 me-4 shadow-sm" style="width:500px">
                <div class="card-header">
                    <h4 class="fw-semibold text-muted">{{ $product->name }}</h4>
                </div>
                <div class="card-body">
                    <p class="text-secondary">{{ Str::limit($product->description, 80) }}</p>
                    <p class="text-primary fw-semibold mt-2">${{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-success float-end">
                        Ver
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
