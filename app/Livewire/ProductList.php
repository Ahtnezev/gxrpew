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

    public function render()
    {
        return view('livewire.product-list', [
            'products' => Product::paginate(3)
        ]);
    }

    public function buy($productId)
    {
        $this->dispatch('request-preference', productId: $productId);
    }
}
