<div>
    <x-mary-header title="Administrar Productos" subtitle="Gestión del catálogo de Polijub" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Buscar..." wire:model.live.debounce="search" />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.create()" label="Nuevo Producto" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table :headers="[
        ['key' => 'id', 'label' => '#'],
        ['key' => 'image', 'label' => 'Imagen'],
        ['key' => 'name', 'label' => 'Nombre'],
        ['key' => 'category.name', 'label' => 'Categoría'],
        ['key' => 'price', 'label' => 'Precio'],
        ['key' => 'is_active', 'label' => 'Activo'],
        ['key' => 'actions', 'label' => 'Acciones', 'class' => 'text-right']
    ]" :rows="$products" striped>
        
        @scope('cell_image', $product)
            <div class="avatar">
                <div class="w-12 rounded">
                    @if(Str::startsWith($product->image, 'http'))
                        <img src="{{ $product->image }}" />
                    @elseif($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" onerror="this.onerror=null;this.src='{{ asset('images/' . $product->image) }}';" />
                    @else
                        <img src="https://via.placeholder.com/150" />
                    @endif
                </div>
            </div>
        @endscope

        @scope('cell_price', $product)
            ${{ number_format($product->price, 2) }}
        @endscope

        @scope('cell_is_active', $product)
            @if($product->is_active)
                <x-mary-badge value="Activo" class="badge-success" />
            @else
                <x-mary-badge value="Inactivo" class="badge-ghost" />
            @endif
        @endscope

        @scope('cell_actions', $product)
            <div class="flex justify-end gap-2">
                <x-mary-button icon="o-pencil" wire:click="edit({{ $product->id }})" class="btn-ghost btn-sm text-blue-500" spinner />
                <x-mary-button icon="o-trash" wire:click="delete({{ $product->id }})" wire:confirm="¿Estás seguro de eliminar este producto?" class="btn-ghost btn-sm text-red-500" spinner />
            </div>
        @endscope

    </x-mary-table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>

    {{-- Modal Create/Edit --}}
    <x-mary-modal wire:model="myModal" class="backdrop-blur" box-class="w-11/12 max-w-5xl">
        <x-slot:title>
            {{ $isEditing ? 'Editar Producto' : 'Nuevo Producto' }}
        </x-slot:title>

        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Columna Izquierda: Datos Básicos --}}
                <div class="space-y-4">
                    <x-mary-input label="Nombre" wire:model="name" placeholder="Ej: Helado de Chocolate" />
                    
                    <x-mary-select label="Categoría" wire:model="category_id" :options="$categories" option-label="name" option-value="id" placeholder="Seleccione una categoría" />
                    
                    <div class="grid grid-cols-2 gap-4">
                        <x-mary-input label="Precio" wire:model="price" prefix="$" type="number" step="0.01" />
                        <x-mary-input label="Max Sabores" wire:model="max_flavors" type="number" hint="0 para sin límite/no aplica" />
                    </div>

                    <x-mary-textarea label="Descripción" wire:model="description" placeholder="Descripción del producto..." rows="3" />
                </div>

                {{-- Columna Derecha: Configuración e Imagen --}}
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
                        <x-mary-file wire:model="image" accept="image/png, image/jpeg, image/webp" crop-after-change>
                            <div class="flex items-center gap-4">
                                <img src="{{ $image ? $image->temporaryUrl() : ($existingImage ? (Str::startsWith($existingImage, 'http') ? $existingImage : asset('storage/'.$existingImage)) : 'https://via.placeholder.com/150') }}" class="h-20 w-20 rounded-lg object-cover border" />
                                <div class="text-sm text-gray-500">
                                    <span class="block">Formatos: JPG, PNG, WEBP</span>
                                    <span class="block">Max: 1MB</span>
                                </div>
                            </div>
                        </x-mary-file>
                    </div>
                </div>
            </div>
        
            <x-slot:actions>
                <x-mary-button label="Cancelar" @click="$wire.myModal = false" />
                <x-mary-button label="Guardar" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </form>
    </x-mary-modal>
</div>