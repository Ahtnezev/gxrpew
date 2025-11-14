<div>
    <h2 class="text-xl font-bold mb-4">Productos</h2>

    @foreach($products as $product)
        <div class="p-3 border rounded mb-3">
            <p>{{ $product->name }} - ${{ $product->price }}</p>

            <button
                class="btn btn-warning"
                wire:click="buy({{ $product->id }})">
                Comprar
            </button>
        </div>
    @endforeach

    <div id="walletBrick_container" class="mt-6"></div>
</div>

<script src="https://sdk.mercadopago.com/js/v2"></script>

<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('request-preference', async ({ productId }) => {

        const response = await fetch(`/checkout/preference/${productId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            }
        });

        const data = await response.json();
        const preferenceId = data.id;

        const mp = new MercadoPago("{{ config('services.mp.public_key') }}");

        const bricksBuilder = mp.bricks();

        await bricksBuilder.create("wallet", "walletBrick_container", {
            initialization: {
                preferenceId: preferenceId,
            },
        });

    });
});
</script>
