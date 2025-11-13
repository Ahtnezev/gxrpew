<div class="container mx-auto py-6">
    <h1 class="text-2xl font-semibold mb-4">Productos disponibles</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($products as $product)
            <livewire:product-payment :product="$product" :key="$product->id" />
        @endforeach
    </div>
</div>
