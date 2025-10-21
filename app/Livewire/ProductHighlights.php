<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductHighlights extends Component
{
    public function render()
    {
        $products = Product::latest()->take(3)->get();

        return view('livewire.product-highlights', [
            'products' => $products,
        ]);
    }
}
