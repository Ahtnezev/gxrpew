<div>
    <a  href="{{ route('cart.index') }}" class="btn btn-warning">
        <i class="fa-solid fa-cart-shopping"></i> Carrito
    </a>

    <div class="mt-4 container d-flex align-items-center justify-content-start flex-wrap">
        @foreach($products as $product)
            <div class="p-4 border rounded mb-4 me-4" style="width:500px;">
                <h3 class="font-bold">{{ $product->name }}</h3>
                <p>${{ number_format($product->price, 2) }}</p>

                <div class="d-flex align-items-center justify-content-between">
                    <livewire:add-to-cart-button :product="$product" :key="$product->id">

                    <a href="{{ route('checkout.show', $product) }}" class="mt-2 btn btn-primary">
                        <i class="fa-solid fa-circle-info"></i> Ver
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    {{ $products->links() }}
</div>

@push('scripts')
<script>
    Livewire.on('notify', (data) => {
        const {id, message} = data[0];
        console.log(id, message);
    });
</script>
@endpush
