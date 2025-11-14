<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function buy($id)
    {
        $response = Http::post(route('checkout.preference', $id));

        $preferenceId = $response->json('id');

        $this->dispatch('mp-open', id: $preferenceId);
    }

    public function render()
    {
        return view('livewire.product-list', [
            'products' => Product::paginate(3)
        ]);
    }
}
