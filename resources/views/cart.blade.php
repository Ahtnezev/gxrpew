@extends('layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route("home") }}" class="btn btn-primary">
        <i class="fa-solid fa-chevron-left"></i> Regresar
    </a>
</div>

<livewire:cart-component />
@endsection
