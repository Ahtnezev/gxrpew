<div>
    <a href="{{ route('cart.index') }}" class="btn btn-warning">
        <i class="fa-solid fa-cart-shopping"></i> Carrito
    </a>

    <div class="mt-4 container d-flex align-items-center justify-content-start flex-wrap">
        @foreach($products as $key => $product)
            <div class="p-4 border mb-4 shadow-sm me-4 card-product">
                <a href="{{ route('checkout.show', $product) }}">
                    <img loading="lazy" src="{{ App\Helpers\RandomImageHelper::getRandomImagePath() }}" class="img-fluid" alt="Nike Product">
                </a>

                <p>
                    <strong>{{ $product->name }}</strong> <br>
                    <em>Lorem ipsum dolor sit amet elit. Eos, ducimus.</em>
                </p>
                <p>
                    <strong>${{ number_format($product->price, 2) }}</strong>
                </p>

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

{{-- @push('scripts')
<script>
    Livewire.on('notify', (data) => {
        const {id, message} = data[0];
        console.log(id, message);
    });
</script>
@endpush --}}

@push('styles')
<style>
    .card-product {
        width: 100%;
    }
    @media screen and (min-width: 576px) {
        .card-product {
            width: calc(100% / 2.4);
        }
    @media screen and (min-width: 768px) {
        .card-product {
            width: calc(100% / 3.5);
        }
    }
    @media screen and (min-width: 992px) {
        .card-product {
            width: calc(100% / 2.3);
        }
    }
</style>
@endpush

