<div>
    <x-mary-header title="Sabores" subtitle="Gestión de sabores" separator>
        <x-slot:actions>
            <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.create()" label="Nuevo Sabor" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table :headers="$headers" :rows="$flavors" striped>
        @scope('cell_color', $flavor)
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-full border border-base-300" style="background-color: {{ $flavor->color }}"></div>
                <span class="text-xs opacity-50">{{ $flavor->color }}</span>
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
                <x-mary-button icon="o-pencil" wire:click="edit({{ $flavor->id }})" class="btn-ghost btn-sm text-blue-500" />
                <x-mary-button icon="o-trash" wire:click="delete({{ $flavor->id }})" wire:confirm="¿Eliminar este sabor?" class="btn-ghost btn-sm text-red-500" />
            </div>
        @endscope
    </x-mary-table>
    
    <div class="mt-4">{{ $flavors->links() }}</div>

    <x-mary-modal wire:model="myModal" class="backdrop-blur">
        <x-mary-form wire:submit="save">
            <x-mary-input label="Nombre" wire:model="name" />
            
            <div class="flex gap-4 items-center">
                <x-mary-input label="Color (Hex)" wire:model="color" class="flex-1" />
                <input type="color" wire:model.live="color" class="h-10 w-10 cursor-pointer rounded border border-base-300 bg-base-100 p-0" />
            </div>

            <x-mary-toggle label="Activo" wire:model="is_active" />
    
            <x-slot:actions>
                <x-mary-button label="Cancelar" @click="$wire.myModal = false" />
                <x-mary-button label="Guardar" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>
