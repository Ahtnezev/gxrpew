<div class="container">
    <div class="row">
        <div class="col-12 col-lg-9 mx-start">
            @if($cart && $cart->items->count())
            <table class="table table-hover">
                <thead><tr><th>Producto</th><th>Cant</th><th>Precio</th><th></th></tr></thead>
                <tbody>
                @foreach($cart->items as $item)
                    <tr>
                        <td><em class="text-secondary">{{ $item->product->name }}</em></td>
                        <td>
                            <input
                                class="form-control form-control-sm"
                                type="number"
                                value="{{ $item->quantity }}"
                                min="1"
                                wire:change="updateQty({{ $item->id }}, $event.target.value)"
                            />
                        </td>
                        <td>${{ number_format($item->unit_price * $item->quantity,2) }}</td>
                        <td><button class="btn btn-sm btn-outline-danger" onclick="showSw({{ $item->id }})">Eliminar</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <blockquote class="blockquote">
                    <strong>Total: </strong> ${{ number_format($cart->items->sum(fn($i)=>$i->unit_price*$i->quantity),2) }}
                </blockquote>
            </div>

            <a href="{{ route('checkout.cart') }}" class="btn btn-success">
                <i class="fa-solid fa-dollar-sign"></i>Ir a pagar
            </a>
        </div>
        @else
            <div class="col-12">
                <p>Tu carrito está vacío.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function showSw(id) {
        Swal.fire({
            text: "¿Eliminar del carrito?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                @this.removeItem(id).then(() => {
                    Swal.fire({
                        text: "Eliminado",
                        icon: "success"
                    });
                });
            }
        });
    }
</script>
@endpush
