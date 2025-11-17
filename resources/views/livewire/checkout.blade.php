<div>
    <h2>Checkout</h2>

    <div>
        @foreach($cart->items as $item)
            <div>{{ $item->product->name }} x {{ $item->quantity }} — ${{ number_format($item->unit_price * $item->quantity,2) }}</div>
        @endforeach
    </div>

    <div class="mt-4">
        <strong>Total:</strong> ${{ number_format($cart->items->sum(fn($i)=>$i->unit_price*$i->quantity),2) }}
    </div>

    @if(!$initPoint)
        <button wire:click="createOrderAndPreference" class="btn btn-primary mt-3">Pagar con Mercado Pago</button>
    @endif

    @if($initPoint)
        <div class="mt-3">
            <a href="{{ $initPoint }}" target="_blank" class="px-4 py-2 bg-green-600 text-white rounded inline-block">Ir al pago</a>
            <p class="text-sm mt-2">Si el pago se completa, Mercado Pago nos notificará por webhook y actualizaremos la orden.</p>
        </div>
    @endif
</div>
