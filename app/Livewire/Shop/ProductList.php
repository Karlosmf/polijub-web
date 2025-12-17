<?php

namespace App\Livewire\Shop;

use App\Models\Category;
use App\Models\Product;
use App\Models\Flavor;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Mary\Traits\Toast;

class ProductList extends Component
{
    use Toast;

    #[Layout('layouts.frontend')]
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

    public function openFlavorSelectionModal(Product $product): void
    {
        $quantity = $this->quantities[$product->id] ?? 1;
        $this->dispatch('open-flavor-modal', 
            productId: $product->id, 
            productName: $product->name, 
            quantity: $quantity, 
            maxFlavors: $product->max_flavors
        );
    }

    #[On('add-to-cart-with-flavors')]
    public function addToCart(int $productId, array $flavors = []): void
    {
        $quantity = $this->quantities[$productId] ?? 1;
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            // If product already in cart, check if it has same flavors, otherwise add as new item
            // For simplicity now, if flavors are selected, treat as new unique item
            // If no flavors selected and product already exists, just update quantity
            if (empty($flavors) && empty($cart[$productId]['flavors'])) {
                 $cart[$productId]['quantity'] += $quantity;
            } else {
                // To store flavors, we need to generate a unique key for the item if flavors differ
                // For now, let's just make a new entry with a unique ID based on product+flavors
                $product = Product::find($productId);
                if ($product) {
                    $itemHash = md5($productId . serialize($flavors)); // Unique hash for product+flavors combination
                    
                    if (isset($cart[$itemHash])) {
                        $cart[$itemHash]['quantity'] += $quantity;
                    } else {
                        // Determine image URL
                        $image = $product->image;
                        if (str_starts_with($image, 'http')) {
                            $imageUrl = $image;
                        } elseif (str_starts_with($image, 'images/') || str_starts_with($image, 'imgs/')) {
                            $imageUrl = '/' . $image;
                        } elseif (!str_contains($image, '/')) {
                            $imageUrl = '/images/' . $image;
                        } else {
                            $imageUrl = '/imgs/' . $image;
                        }

                        $flavorNames = Flavor::whereIn('id', $flavors)->pluck('name')->implode(', ');

                        $cart[$itemHash] = [
                            'id' => $productId,
                            'unique_id' => $itemHash, // Store a unique ID for this specific cart item
                            'name' => $product->name,
                            'description' => $product->description,
                            'price' => $product->price,
                            'image' => $imageUrl,
                            'quantity' => $quantity,
                            'flavors' => $flavors,
                            'flavor_names' => $flavorNames,
                        ];
                    }
                }
            }
        } else {
            $product = Product::find($productId);
            if ($product) {
                 // Determine image URL
                $image = $product->image;
                if (str_starts_with($image, 'http')) {
                    $imageUrl = $image;
                } elseif (str_starts_with($image, 'images/') || str_starts_with($image, 'imgs/')) {
                    $imageUrl = '/' . $image;
                } elseif (!str_contains($image, '/')) {
                    $imageUrl = '/images/' . $image;
                } else {
                    $imageUrl = '/imgs/' . $image;
                }

                $flavorNames = Flavor::whereIn('id', $flavors)->pluck('name')->implode(', ');
                $itemHash = md5($productId . serialize($flavors)); // Unique hash for product+flavors combination

                $cart[$itemHash] = [
                    'id' => $productId,
                    'unique_id' => $itemHash,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'image' => $imageUrl,
                    'quantity' => $quantity,
                    'flavors' => $flavors,
                    'flavor_names' => $flavorNames,
                ];
            }
        }
        
        session()->put('cart', $cart);
        
        $this->dispatch('product-added-to-cart'); 
        $this->success('Producto agregado al carrito');
    }

    public function render(): mixed
    {
        $categories = Category::all();
        $products = Product::when($this->selectedCategory, function ($query) {
            $query->where('category_id', $this->selectedCategory);
        })->get();

        // Ensure all displayed products have a quantity of at least 1 initialized
        foreach ($products as $product) {
            if (!isset($this->quantities[$product->id])) {
                $this->quantities[$product->id] = 1;
            }
        }

        return view('livewire.shop.product-list', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
