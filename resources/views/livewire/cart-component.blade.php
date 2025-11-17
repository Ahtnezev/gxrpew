<div>
    @if($cart && $cart->items->count())
        <table class="w-full">
            <thead><tr><th>Producto</th><th>Cant</th><th>Precio</th><th></th></tr></thead>
            <tbody>
            @foreach($cart->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>
                        <input type="number" value="{{ $item->quantity }}" min="1" wire:change="updateQty({{ $item->id }}, $event.target.value)" />
                    </td>
                    <td>${{ number_format($item->unit_price * $item->quantity,2) }}</td>
                    <td><button wire:click="removeItem({{ $item->id }})">Eliminar</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <strong>Total: </strong> ${{ number_format($cart->items->sum(fn($i)=>$i->unit_price*$i->quantity),2) }}
        </div>

        <a href="{{ route('checkout.cart') }}" class="btn btn-success">Ir a pagar</a>
    @else
        <p>Tu carrito está vacío.</p>
    @endif
</div>
