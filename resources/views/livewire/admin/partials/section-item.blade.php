@foreach($items as $index => $item)
    @php
        $currentPath = $parentPath === "" ? "$index" : "$parentPath.children.$index";
        $libName = $item['component'] === 'container-component' ? 'container' : $item['component'];
        $libComp = collect($library)->firstWhere('name', $libName);
        $isContainer = ($item['component'] === 'container-component');
    @endphp

    <div class="bg-base-100 border border-base-300 rounded-xl shadow-md hover:shadow-lg transition-all mb-4 overflow-hidden">
        <div class="flex items-center justify-between p-3 bg-base-200/40 border-b border-base-300">
            <div class="flex items-center gap-3">
                <div class="bg-primary text-white p-1.5 rounded-lg flex items-center justify-center">
                    @if(isset($libComp['icon']))
                        <x-dynamic-component :component="$libComp['icon']" class="w-5 h-5" />
                    @else
                        <x-mary-icon name="o-puzzle-piece" class="w-5 h-5" />
                    @endif
                </div>
                <div>
                    <span class="font-bold text-sm block">{{ $libComp['label'] ?? $item['component'] }}</span>
                    <span class="text-[10px] opacity-50 font-mono italic">#{{ $item['id'] }}</span>
                </div>
            </div>
            
            <div class="flex items-center gap-1">
                @if($isContainer)
                    <x-mary-dropdown label="Añadir Hijo" icon="o-plus" class="btn-ghost btn-xs text-success">
                        @foreach($library as $l)
                            <x-mary-menu-item :title="$l['label']" wire:click="addComponent('{{ $l['name'] }}', '{{ $currentPath }}')" />
                        @endforeach
                    </x-mary-dropdown>
                @endif
                <x-mary-button label="Editar" icon="o-pencil" class="btn-ghost btn-xs text-primary" wire:click="editComponent('{{ $currentPath }}')" />
                <x-mary-button label="Copiar" icon="o-document-duplicate" class="btn-ghost btn-xs text-info" wire:click="duplicateComponent('{{ $currentPath }}')" />
                <x-mary-button icon="o-trash" class="btn-ghost btn-xs text-error" wire:click="deleteComponent('{{ $currentPath }}')" confirm="¿Eliminar componente?" />
            </div>
        </div>

        @if($isContainer)
            <div class="p-4 bg-base-100/30 ml-4 border-l-2 border-dashed border-base-300">
                @if(isset($item['children']) && count($item['children']) > 0)
                    @include('livewire.admin.partials.section-item', ['items' => $item['children'], 'parentPath' => $currentPath])
                @else
                    <div class="text-xs opacity-40 py-4 text-center italic">Contenedor vacío</div>
                @endif
            </div>
        @endif
    </div>
@endforeach
