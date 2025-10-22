<?php

namespace App\Livewire\Shop;

use App\Models\Category;
use App\Models\Product;
use Livewire\Volt\Component;

class ProductList extends Component
{
    public $selectedCategory = null;

    public function render(): mixed
    {
        $categories = Category::all();
        $products = Product::when($this->selectedCategory, function ($query) {
            $query->where('category_id', $this->selectedCategory);
        })->get();

        return view('livewire.shop.product-list', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
