<div>
    <x-mary-header title="Administrar Sabores" subtitle="Gestión de gustos de helado" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Buscar sabor..." wire:model.live.debounce="search" />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.create()" label="Nuevo Sabor" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table :headers="[
        ['key' => 'id', 'label' => '#'],
        ['key' => 'image', 'label' => 'Imagen'],
        ['key' => 'name', 'label' => 'Nombre'],
        ['key' => 'tags', 'label' => 'Categorías'],
        ['key' => 'is_active', 'label' => 'Activo'],
        ['key' => 'actions', 'label' => 'Acciones', 'class' => 'text-right']
    ]" :rows="$flavors" striped>
        
        @scope('cell_image', $flavor)
            <div class="avatar">
                <div class="w-12 rounded">
                    @if(Str::startsWith($flavor->image, 'http'))
                        <img src="{{ $flavor->image }}" />
                    @elseif($flavor->image)
                        <img src="{{ asset('storage/' . $flavor->image) }}" onerror="this.onerror=null;this.src='{{ asset('images/' . $flavor->image) }}';" />
                    @else
                        <img src="https://via.placeholder.com/150" />
                    @endif
                </div>
            </div>
        @endscope

        @scope('cell_tags', $flavor)
            <div class="flex flex-wrap gap-1">
                @foreach($flavor->tags as $tag)
                    <x-mary-badge :value="$tag->name" class="text-white" style="background-color: {{ $tag->color }}" />
                @endforeach
            </div>
        @endscope

        @scope('cell_is_active', $flavor)
            @if($flavor->is_active)
                <x-mary-badge value="Activo" class="badge-success" />
            @else
                <x-mary-badge value="Inactivo" class="badge-ghost" />
            @endif
        @endscope

        @scope('cell_actions', $flavor)
            <div class="flex justify-end gap-2">
                <x-mary-button icon="o-pencil" wire:click="edit({{ $flavor->id }})" class="btn-ghost btn-sm text-blue-500" spinner />
                <x-mary-button icon="o-trash" wire:click="delete({{ $flavor->id }})" wire:confirm="¿Estás seguro de eliminar este sabor?" class="btn-ghost btn-sm text-red-500" spinner />
            </div>
        @endscope

    </x-mary-table>

    <div class="mt-4">
        {{ $flavors->links() }}
    </div>

    {{-- Modal Create/Edit --}}
    <x-mary-modal wire:model="myModal" class="backdrop-blur" box-class="w-11/12 max-w-5xl">
        <x-slot:title>
            {{ $isEditing ? 'Editar Sabor' : 'Nuevo Sabor' }}
        </x-slot:title>

        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <x-mary-input label="Nombre del Gusto" wire:model="name" placeholder="Ej: Chocolate Suizo" />
                    
                    <x-mary-textarea label="Descripción" wire:model="description" placeholder="Breve descripción del sabor..." rows="3" />
                    
                    {{-- Multi-select for Tags --}}
                    <x-mary-choices label="Categorías" wire:model="tags" :options="$availableTags" option-label="name" option-value="id" searchable />
                </div>

                <div class="space-y-4">
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

                    <x-mary-toggle label="Sabor Activo" wire:model="is_active" right />
                </div>
            </div>
        
            <x-slot:actions>
                <x-mary-button label="Cancelar" @click="$wire.myModal = false" />
                <x-mary-button label="Guardar" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </form>
    </x-mary-modal>
</div>
