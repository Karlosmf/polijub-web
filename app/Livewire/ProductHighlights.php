<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Volt\Component;

class ProductHighlights extends Component
{
    public function render(): mixed
    {
        $products = Product::latest()->take(3)->get();

        return view('livewire.product-highlights', [
            'products' => $products,
        ]);
    }
}
