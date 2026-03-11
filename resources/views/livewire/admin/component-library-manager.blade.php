<div>
    <x-mary-header title="Librería de Componentes" subtitle="Define los componentes disponibles y sus atributos configurables" separator>
        <x-slot:actions>
            <x-mary-button label="Nuevo Componente" icon="o-plus" class="btn-primary" wire:click="addComponent" />
        </x-slot:actions>
    </x-mary-header>

    @if (session()->has('message'))
        <div class="alert alert-success mb-4 text-white">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($library as $index => $comp)
            <x-mary-card subtitle="Livewire: {{ $comp['name'] }}" shadow class="shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-base-300">
                <x-slot:title>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-primary/10 rounded-lg">
                            @if(isset($comp['icon']))
                                <x-dynamic-component :component="$comp['icon']" class="w-6 h-6 text-primary" />
                            @else
                                <x-mary-icon name="o-puzzle-piece" class="w-6 h-6 text-primary" />
                            @endif
                        </div>
                        <span class="font-bold text-lg">{{ $comp['label'] }}</span>
                    </div>
                </x-slot:title>
                
                <div class="text-sm opacity-70">
                    {{ count($comp['attributes'] ?? []) }} Atributos definidos
                </div>
                
                <x-slot:actions>
                    <x-mary-button icon="o-pencil" class="btn-ghost btn-sm" wire:click="editComponent({{ $index }})" />
                    <x-mary-button icon="o-trash" class="btn-ghost btn-sm text-error" wire:click="deleteComponent({{ $index }})" confirm="¿Estás seguro?" />
                </x-slot:actions>
            </x-mary-card>
        @endforeach
    </div>

    <!-- Modal de Edición -->
    <x-mary-modal wire:model="showModal" :title="$editingComponent !== null ? 'Editar Componente' : 'Nuevo Componente'" class="backdrop-blur" separator>
        <x-slot:actions>
            <div class="flex items-center gap-4 mr-4">
                <span class="text-xs font-bold uppercase {{ $isCodeMode ? 'opacity-50' : '' }}">Visual</span>
                <x-mary-toggle wire:model.live="isCodeMode" tight />
                <span class="text-xs font-bold uppercase {{ $isCodeMode ? 'text-primary' : 'opacity-50' }}">JSON</span>
            </div>
            <x-mary-button label="Cancelar" @click="$wire.showModal = false" />
            <x-mary-button label="Guardar Componente" class="btn-primary" wire:click="saveComponent" spinner="saveComponent" />
        </x-slot:actions>

        @if (session()->has('error'))
            <div class="alert alert-error mb-4 text-white text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-4 max-h-[65vh] overflow-y-auto p-1">
            @if($isCodeMode)
                <div class="space-y-2">
                    <div class="text-xs opacity-50 mb-1 flex justify-between items-center">
                        <span>Definición de Esquema</span>
                        <span class="badge badge-ghost badge-sm font-mono">JSON</span>
                    </div>
                    <x-mary-textarea 
                        wire:model="rawJson" 
                        rows="20" 
                        class="font-mono text-xs bg-neutral text-neutral-content p-4 leading-relaxed" 
                        placeholder='{ "name": "...", "label": "...", "attributes": [] }'
                    />
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-mary-input label="Nombre Interno" wire:model="componentData.name" placeholder="ej: mi-componente" />
                    <x-mary-input label="Etiqueta Visible" wire:model="componentData.label" placeholder="ej: Banner Principal" />
                    <x-mary-input label="Icono (phosphor-)" wire:model="componentData.icon" placeholder="ej: phosphor-star" />
                </div>

                <div class="divider">Atributos</div>

                @foreach($componentData['attributes'] ?? [] as $attrIndex => $attr)
                    <div class="bg-base-200 p-4 rounded-lg relative group border border-base-300">
                        <div class="grid grid-cols-2 gap-4">
                            <x-mary-input label="Variable ($prop)" wire:model="componentData.attributes.{{ $attrIndex }}.name" />
                            <x-mary-input label="Label en UI" wire:model="componentData.attributes.{{ $attrIndex }}.label" />
                            <x-mary-select label="Tipo" wire:model="componentData.attributes.{{ $attrIndex }}.type" :options="[
                                ['id' => 'text', 'name' => 'Texto'],
                                ['id' => 'textarea', 'name' => 'Área de Texto'],
                                ['id' => 'number', 'name' => 'Número'],
                                ['id' => 'color', 'name' => 'Color'],
                                ['id' => 'image', 'name' => 'Imagen'],
                                ['id' => 'toggle', 'name' => 'Toggle (Switch)']
                            ]" />
                            <x-mary-input label="Default" wire:model="componentData.attributes.{{ $attrIndex }}.default" />
                        </div>
                        <x-mary-button icon="o-x-mark" class="btn-xs btn-circle btn-ghost absolute -top-2 -right-2 text-error" wire:click="removeAttribute({{ $attrIndex }})" />
                    </div>
                @endforeach

                <x-mary-button label="Añadir Atributo" icon="o-plus" class="btn-sm btn-outline btn-primary w-full" wire:click="addAttribute" />
            @endif
        </div>
    </x-mary-modal>
</div>
