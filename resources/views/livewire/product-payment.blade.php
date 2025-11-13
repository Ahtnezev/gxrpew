<div class="card text-center shadow-sm">
    <div class="card-body">
        <h5 class="font-semibold">{{ $product->name }}</h5>
        <p class="text-gray-500">{{ $product->description }}</p>
        <p class="text-lg font-bold mb-2">${{ number_format($product->price, 2) }} MXN</p>

        <button wire:click="createPreference" class="btn btn-warning">
            Pagar con Mercado Pago
        </button>

        <div id="wallet_container_{{ $product->id }}" class="mt-3"></div>
    </div>
</div>

@push('scripts')
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        document.addEventListener('livewire:render-wallet', async (e) => {
            const { id, productId } = e.detail;
            const mp = new MercadoPago("{{ env('MP_PUBLIC_KEY') }}", { locale: 'es-MX' });
            const bricksBuilder = mp.bricks();
            await bricksBuilder.create("wallet", `wallet_container_${productId}`, {
                initialization: { preferenceId: id }
            });
        });
    </script>
@endpush
