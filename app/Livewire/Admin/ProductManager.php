<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

#[Layout('layouts.admin')]
class ProductManager extends Component
{
    use WithPagination, WithFileUploads, Toast;

    public bool $myModal = false;
    public bool $isEditing = false;

    // Form Fields
    public $productId;
    
    #[Rule('required|min:3')]
    public string $name = '';

    #[Rule('nullable|string')]
    public string $description = '';

    #[Rule('required|numeric|min:0')]
    public $price;

    #[Rule('required|exists:categories,id')]
    public $category_id;

    #[Rule('nullable|image|max:1024')] // 1MB Max
    public $image;
    
    public $existingImage; // To show preview when editing

    #[Rule('required|integer|min:0')]
    public int $max_flavors = 0;

    public bool $is_delivery_available = true;
    public bool $is_active = true;

    // Search
    public string $search = '';

    public function mount()
    {
        if (request()->query('create')) {
            $this->create();
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'max_flavors' => $this->max_flavors,
            'is_delivery_available' => $this->is_delivery_available,
            'is_active' => $this->is_active,
        ];

        // Handle Image Upload
        if ($this->image) {
            // Save to 'public' disk in 'products' folder.
            // Ensure you have run: php artisan storage:link
            $path = $this->image->store('products', 'public');
            $data['image'] = $path;
        }

        if ($this->isEditing) {
            $product = Product::find($this->productId);
            // If updating and no new image, keep old one.
            if (!$this->image) {
                unset($data['image']); 
            }
            $product->update($data);
            $this->success('Producto actualizado correctamente.');
        } else {
            // Required image for new products or default.
            if (!$this->image && !isset($data['image'])) {
                $data['image'] = 'images/default-product.webp'; // Fallback
            }
            Product::create($data);
            $this->success('Producto creado correctamente.');
        }

        $this->myModal = false;
        $this->resetForm();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description ?? '';
        $this->price = $product->price;
        $this->category_id = $product->category_id;
        $this->existingImage = $product->image;
        $this->max_flavors = $product->max_flavors;
        $this->is_delivery_available = $product->is_delivery_available;
        $this->is_active = $product->is_active;
        
        $this->image = null; // Reset file input
        $this->isEditing = true;
        $this->myModal = true;
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->myModal = true;
    }

    public function delete($id)
    {
        Product::destroy($id);
        $this->success('Producto eliminado.');
    }

    public function resetForm()
    {
        $this->reset(['productId', 'name', 'description', 'price', 'category_id', 'image', 'existingImage', 'max_flavors', 'is_delivery_available', 'is_active']);
        // Set defaults
        $this->max_flavors = 0;
        $this->is_delivery_available = true;
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function render()
    {
        $products = Product::with('category')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.product-manager', [
            'products' => $products,
            'categories' => Category::all(),
        ]);
    }
}