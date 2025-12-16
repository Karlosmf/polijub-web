<div>
    <x-header title="Administrar Etiquetas" subtitle="Tags para clasificar productos" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="o-plus" class="btn-primary" @click="$wire.create()" label="Nueva Etiqueta" />
        </x-slot:actions>
    </x-header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($tags as $tag)
            <div class="bg-zinc-800/40 p-4 rounded-lg shadow flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 rounded-full shadow-sm" style="background-color: {{ $tag->color }}"></div>
                    <span class="font-bold">{{ $tag->name }}</span>
                </div>
                <div class="flex gap-1">
                    <x-button icon="o-pencil" wire:click="edit({{ $tag->id }})"
                        class="btn-ghost btn-sm btn-circle text-blue-500" />
                    <x-button icon="o-trash" wire:click="delete({{ $tag->id }})" wire:confirm="¿Eliminar etiqueta?"
                        class="btn-ghost btn-sm btn-circle text-red-500" />
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modal --}}
    <x-modal wire:model="myModal" class="backdrop-blur">
        <x-slot:title>
            {{ $isEditing ? 'Editar Etiqueta' : 'Nueva Etiqueta' }}
        </x-slot:title>

        <form wire:submit="save" class="space-y-4">
            <x-input label="Nombre" wire:model="name" placeholder="Ej: Sin TACC, Oferta, Nuevo..." />

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Color del Badge</span>
                </label>
                <div class="flex items-center gap-4">
                    <input type="color" wire:model.live="color"
                        class="p-1 h-10 w-20 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none"
                        title="Elegir color">
                    <div class="px-3 py-1 rounded-full text-white text-sm font-bold shadow-sm"
                        style="background-color: {{ $color }}">
                        Vista Previa
                    </div>
                </div>
            </div>

            <x-slot:actions>
                <x-button label="Cancelar" wire:click="$set('myModal', false)" />
                <x-button label="Guardar" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </form>
    </x-modal>
</div>