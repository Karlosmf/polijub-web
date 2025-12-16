<div>
    <x-mary-header title="Etiquetas" subtitle="Gestión de etiquetas" separator>
        <x-slot:actions>
            <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.create()" label="Nueva Etiqueta" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table :headers="$headers" :rows="$tags" striped>
        @scope('cell_color', $tag)
             <div class="flex items-center gap-2">
                <x-mary-badge :value="$tag->name" style="background-color: {{ $tag->color }}; color: white;" />
                <span class="text-xs opacity-50">{{ $tag->color }}</span>
            </div>
        @endscope

        @scope('cell_actions', $tag)
            <div class="flex justify-end gap-2">
                <x-mary-button icon="o-pencil" wire:click="edit({{ $tag->id }})" class="btn-ghost btn-sm text-blue-500" />
                <x-mary-button icon="o-trash" wire:click="delete({{ $tag->id }})" wire:confirm="¿Eliminar etiqueta?" class="btn-ghost btn-sm text-red-500" />
            </div>
        @endscope
    </x-mary-table>
    
    <div class="mt-4">{{ $tags->links() }}</div>

    <x-mary-modal wire:model="myModal" class="backdrop-blur">
        <x-mary-form wire:submit="save">
            <x-mary-input label="Nombre" wire:model="name" />
            
            <div class="flex gap-4 items-center">
                <x-mary-input label="Color" wire:model="color" class="flex-1" />
                <input type="color" wire:model.live="color" class="h-10 w-10 cursor-pointer rounded border border-base-300 bg-base-100 p-0" />
            </div>
    
            <x-slot:actions>
                <x-mary-button label="Cancelar" @click="$wire.myModal = false" />
                <x-mary-button label="Guardar" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>
