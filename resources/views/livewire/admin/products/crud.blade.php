<?php

use Livewire\Volt\Component;
use App\Models\Category;
use App\Models\Product;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Mary\Traits\Toast;

new #[Layout('layouts.admin')] class extends Component {
    use WithFileUploads, Toast;

    public bool $isEditing = false;
    public $productId;
    
    #[Rule('required|min:3')]
    public string $name = '';

    #[Rule('nullable|string')]
    public string $description = '';

    #[Rule('required|numeric|min:0')]
    public $price;

    #[Rule('required|exists:categories,id')]
    public $category_id;

    #[Rule('nullable|image|max:1024')]
    public $image;
    
    public $imageUrl;

    #[Rule('required|integer|min:0')]
    public int $max_flavors = 0;

    public bool $is_delivery_available = true;
    public bool $is_active = true;

    public function mount($id = null)
    {
        if ($id) {
            $product = Product::findOrFail($id);
            $this->isEditing = true;
            $this->productId = $product->id;
            $this->name = $product->name;
            $this->description = $product->description ?? '';
            $this->price = $product->price;
            $this->category_id = $product->category_id;
            $this->max_flavors = $product->max_flavors;
            $this->is_delivery_available = $product->is_delivery_available;
            $this->is_active = $product->is_active;

            if (str_starts_with($product->image, 'http')) {
                $this->imageUrl = $product->image;
            } elseif (str_starts_with($product->image, 'images/') || str_starts_with($product->image, 'imgs/')) {
                $this->imageUrl = '/' . $product->image;
            } elseif (!str_contains($product->image, '/')) {
                $this->imageUrl = '/images/' . $product->image;
            } else {
                $this->imageUrl = '/imgs/' . $product->image;
            }
        } else {
            // Defaults
            $this->isEditing = false;
            $this->max_flavors = 0;
            $this->is_delivery_available = true;
            $this->is_active = true;
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

        if ($this->image) {
            $path = $this->image->store('products', 'app_public_imgs');
            $data['image'] = $path;
        }

        if ($this->isEditing) {
            $product = Product::find($this->productId);
            if (!$this->image) {
                unset($data['image']); 
            }
            $product->update($data);
            $this->success('Producto actualizado correctamente.', redirectTo: route('admin.products'));
        } else {
            if (!$this->image && !isset($data['image'])) {
                $data['image'] = 'images/default.webp'; 
            }
            Product::create($data);
            $this->success('Producto creado correctamente.', redirectTo: route('admin.products'));
        }
    }

    public function delete()
    {
        if ($this->productId) {
            Product::destroy($this->productId);
            $this->success('Producto eliminado.', redirectTo: route('admin.products'));
        }
    }
    
    public function with(): array
    {
        return [
            'categories' => Category::all()
        ];
    }
}; ?>

<div>
    <x-mary-header :title="$isEditing ? 'Editar Producto' : 'Nuevo Producto'" separator />

    <form wire:submit="save" id="product-form">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="space-y-4">
                <x-mary-input label="Nombre" wire:model="name" placeholder="Ej: Helado de Chocolate" />
                
                <x-mary-select label="Categoría" wire:model="category_id" :options="$categories" option-label="name" option-value="id" placeholder="Seleccione una categoría" />
                
                <div class="grid grid-cols-2 gap-4">
                    <x-mary-input label="Precio" wire:model="price" prefix="$" type="number" step="0.01" />
                    <x-mary-input label="Max Sabores" wire:model="max_flavors" type="number" hint="0 para sin límite/no aplica" />
                </div>

                <x-mary-textarea label="Descripción" wire:model="description" placeholder="Descripción del producto..." rows="3" />
            </div>

            <div class="space-y-4">
                <div class="card bg-base-200 p-4">
                    <h4 class="font-bold mb-2 text-sm uppercase text-gray-500">Configuración</h4>
                    <div class="flex flex-col gap-2">
                        <x-mary-toggle label="Disponible para Delivery" wire:model="is_delivery_available" right />
                        <x-mary-toggle label="Producto Activo" wire:model="is_active" right />
                    </div>
                </div>

                <div class="card bg-base-200 p-4">
                    <h4 class="font-bold mb-2 text-sm uppercase text-gray-500">Imagen</h4>
                    <x-mary-file wire:model="image" accept="image/png, image/jpeg, image/webp">
                        <div class="flex items-center gap-4 cursor-pointer w-full">
                            <div class="avatar">
                                <div class="w-20 h-20 rounded-lg border border-gray-300 bg-base-100">
                                    @if($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-full" />
                                    @elseif($imageUrl)
                                        <img src="{{ $imageUrl }}" class="object-cover w-full h-full" onerror="this.onerror=null;this.src='/images/default.webp';" />
                                    @else
                                        <div class="flex items-center justify-center w-full h-full bg-gray-100 text-gray-400">
                                            <img src="/images/default.webp" class="object-cover w-full h-full" />
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 text-sm text-gray-500">
                                <span class="font-bold text-primary block mb-1">Click para cambiar</span>
                                <span class="block text-xs">JPG, PNG, WEBP (Max: 1MB)</span>
                            </div>
                        </div>
                    </x-file>
                    @error('image') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    
        <div class="flex justify-between items-center mt-6">
            <div>
                @if($isEditing)
                    <x-mary-button label="Eliminar" icon="o-trash" wire:click="delete" wire:confirm="¿Estás seguro de eliminar este producto?" class="btn-error btn-ghost" />
                @endif
            </div>
            <div class="flex gap-2">
                <x-mary-button label="Cancelar" link="{{ route('admin.products') }}" />
                <x-mary-button label="Guardar" class="btn-primary" type="submit" spinner="save" form="product-form" />
            </div>
        </div>
    </form>
</div>
