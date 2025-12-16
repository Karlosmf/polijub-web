<?php

use Livewire\Volt\Component;
use App\Models\Product;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component {
    use WithPagination;

    public string $search = '';

    public function with(): array
    {
        return [
            'products' => Product::with('category')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ];
    }
}; ?>

<div>
    <x-header title="Administrar Productos" subtitle="Gestión del catálogo de Polijub" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Buscar..." wire:model.live.debounce="search" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button icon="o-plus" class="btn-primary" link="{{ route('admin.products.create') }}" label="Nuevo Producto" />
        </x-slot:actions>
    </x-header>

    <x-table :headers="[
        ['key' => 'id', 'label' => '#'],
        ['key' => 'image', 'label' => 'Imagen'],
        ['key' => 'name', 'label' => 'Nombre'],
        ['key' => 'category.name', 'label' => 'Categoría'],
        ['key' => 'price', 'label' => 'Precio'],
        ['key' => 'is_active', 'label' => 'Activo']
    ]" :rows="$products" :link="route('admin.products.edit', ['id' => '[id]'])" striped>
        
        @scope('cell_image', $product)
            <div class="avatar">
                <div class="w-12 rounded">
                    @if(str_starts_with($product->image, 'http'))
                        <img src="{{ $product->image }}" onerror="this.onerror=null;this.src='/images/default.webp';" />
                    @elseif(str_starts_with($product->image, 'images/') || str_starts_with($product->image, 'imgs/'))
                        <img src="{{ '/' . $product->image }}" onerror="this.onerror=null;this.src='/images/default.webp';" />
                    @elseif(!str_contains($product->image, '/'))
                        <img src="{{ '/images/' . $product->image }}" onerror="this.onerror=null;this.src='/images/default.webp';" />
                    @else
                        <img src="{{ '/imgs/' . $product->image }}" onerror="this.onerror=null;this.src='/images/default.webp';" />
                    @endif
                </div>
            </div>
        @endscope

        @scope('cell_price', $product)
            ${{ number_format($product->price, 2) }}
        @endscope

        @scope('cell_is_active', $product)
            @if($product->is_active)
                <x-badge value="Activo" class="badge-success" />
            @else
                <x-badge value="Inactivo" class="badge-ghost" />
            @endif
        @endscope

    </x-table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
