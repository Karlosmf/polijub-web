<?php

namespace App\Livewire\Shop;

use App\Models\Category;
use App\Models\Product;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

class ProductList extends Component
{
    #[Layout('layouts.app')]
    public $selectedCategory = null;
    public array $quantities = [];

    public function mount(): void
    {
        // Initialize quantities for all products, though products are loaded in render
        // This will be re-initialized per product on first interaction if not set
    }

    public function incrementQuantity(int $productId): void
    {
        if (!isset($this->quantities[$productId])) {
            $this->quantities[$productId] = 1;
        }
        $this->quantities[$productId]++;
    }

    public function decrementQuantity(int $productId): void
    {
        if (!isset($this->quantities[$productId])) {
            $this->quantities[$productId] = 1;
        }
        if ($this->quantities[$productId] > 1) {
            $this->quantities[$productId]--;
        }
    }

    public function addToCart(int $productId): void
    {
        $quantity = $this->quantities[$productId] ?? 1; // Default to 1 if not set
        $this->dispatch('product-added-to-cart', productId: $productId, quantity: $quantity);
    }

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
