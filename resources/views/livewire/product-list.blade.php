<div class="container py-4">
    <h1 class="mb-4 text-2xl font-semibold">Productos disponibles</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($products as $product)
            <div class="p-4 border rounded-xl shadow-sm text-center">
                <h5 class="font-bold">{{ $product->name }}</h5>
                <p class="text-gray-500">{{ $product->description }}</p>
                <p class="text-lg font-semibold mb-2">${{ number_format($product->price, 2) }} MXN</p>

                <div id="wallet_container_{{ $product->id }}"></div>
            </div>
        @endforeach
    </div>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        document.addEventListener('livewire:navigated', initBricks);
        document.addEventListener('livewire:load', initBricks);

        function initBricks() {
            const mp = new MercadoPago("{{ env('MP_PUBLIC_KEY') }}", { locale: 'es-MX' });
            const bricksBuilder = mp.bricks();

            @foreach($products as $product)
                fetch("{{ route('checkout.create', $product->id) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    renderWalletBrick(bricksBuilder, data.preference_id, {{ $product->id }});
                });
            @endforeach
        }

        async function renderWalletBrick(bricksBuilder, preferenceId, productId) {
            await bricksBuilder.create("wallet", `wallet_container_${productId}`, {
                initialization: { preferenceId: preferenceId }
            });
        }
    </script>
</div>
