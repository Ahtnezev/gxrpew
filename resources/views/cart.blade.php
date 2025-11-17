@extends('layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route("products.index") }}" class="btn btn-primary">Regresar</a>
</div>

<livewire:cart-component />
@endsection
