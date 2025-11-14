<div>
    <div class="container">
        @if (count($products) > 0)
            @foreach($products as $product)
                <div class="card bg-secondary shadow-sm mb-4">
                    <div class="card-body p-5">
                        <h3 class="fw-bold text-lg">{{ $product->name }}</h3>
                        <p class="text-sm">{{ $product->description }}</p>
                        <p class="fw-semibold">${{ $product->price }}</p>

                        <button
                            wire:click="buy({{ $product->id }})"
                            class="mt-3 px-4 py-2 btn btn-warning"
                        >
                            Comprar
                        </button>
                    </div>
                </div>
            @endforeach
            {{ $products->links() }}
        @endif
    </div>
</div>

@push('scripts')
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    document.addEventListener('livewire:init', () => {
        const mp = new MercadoPago("{{ config('services.mp.public_key') }}");

        Livewire.on("mp-open", ({ id }) => {
            mp.checkout({
                preference: { id },
                autoOpen: true,
            });
        });
    });
</script>
@endpush
