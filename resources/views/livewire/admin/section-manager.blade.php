<div>
    <x-mary-header title="Gestor de Secciones" subtitle="Configura el contenido de tus páginas" separator progress-indicator />

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar: Lista de Archivos (Páginas) -->
        <div class="col-span-1">
            <x-mary-card title="Páginas" shadow class="bg-base-200">
                <div class="space-y-1">
                    @foreach($files as $file)
                        <button 
                            wire:click="selectFile('{{ $file }}')" 
                            class="w-full text-left px-3 py-2 rounded-lg hover:bg-primary hover:text-white transition-colors {{ $currentFile === $file ? 'bg-primary text-white shadow-md' : '' }}"
                        >
                            <x-mary-icon name="o-document" class="w-4 h-4 mr-2" />
                            {{ str_replace('.json', '', $file) }}
                        </button>
                    @endforeach
                </div>

                <x-slot:actions>
                    <div class="flex flex-col gap-2 w-full pt-4 border-t border-base-300">
                        <x-mary-input label="Nueva Página" wire:model="newFileName" placeholder="nombre-pagina" />
                        <x-mary-button label="Crear" wire:click="createFile" icon="o-plus" class="btn-primary btn-sm" />
                    </div>
                </x-slot:actions>
            </x-mary-card>
        </div>

        <!-- Editor: Lista de Componentes -->
        <div class="col-span-1 md:col-span-3">
            @if($currentFile)
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold flex items-center">
                        <x-mary-icon name="o-window" class="w-6 h-6 mr-2" />
                        Editando: {{ str_replace('.json', '', $currentFile) }}
                    </h2>
                    
                    <x-mary-dropdown label="Añadir Componente" icon="o-plus" class="btn-success">
                        @foreach($library as $libComp)
                            <x-mary-menu-item :title="$libComp['label']" wire:click="addComponent('{{ $libComp['name'] }}')" />
                        @endforeach
                    </x-mary-dropdown>
                </div>

                <div class="space-y-4">
                    {{-- Usamos un template recursivo mediante @include --}}
                    @include('livewire.admin.partials.section-item', ['items' => $sections, 'parentPath' => ''])

                    @if(count($sections) === 0)
                        <div class="text-center py-20 border-2 border-dashed rounded-2xl border-base-300 opacity-50">
                            <x-mary-icon name="o-puzzle-piece" class="w-12 h-12 mx-auto mb-4" />
                            <p>Esta página aún no tiene componentes.<br>Usa el botón "Añadir Componente" para empezar.</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-96 border-2 border-dashed rounded-2xl border-base-300 opacity-40">
                    <x-mary-icon name="o-cursor-arrow-rays" class="w-16 h-16 mb-4" />
                    <p class="text-xl">Selecciona una página de la izquierda para comenzar a editar</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal para editar atributos -->
    <x-mary-modal wire:model="showEditModal" title="Editar Componente" class="backdrop-blur" separator w-full max-w-4xl>
        <x-slot:actions>
            <div class="flex flex-1 items-center gap-4">
                <span class="text-xs font-bold uppercase {{ $isCodeMode ? 'opacity-50' : '' }}">Form</span>
                <x-mary-toggle wire:model.live="isCodeMode" tight />
                <span class="text-xs font-bold uppercase {{ $isCodeMode ? 'text-primary' : 'opacity-50' }}">JSON</span>
            </div>
            <x-mary-button label="Cancelar" @click="$wire.showEditModal = false" />
            <x-mary-button label="Guardar" class="btn-primary" wire:click="saveComponentEdits" spinner="saveComponentEdits" />
        </x-slot:actions>

        @if (session()->has('error'))
            <div class="alert alert-error mb-4 text-white text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 max-h-[75vh] overflow-y-auto p-1">
            @if($isCodeMode)
                <x-mary-textarea wire:model="rawJson" rows="25" class="font-mono text-xs bg-neutral text-neutral-content p-4" />
            @else
                @if($editingSchema)
                    @foreach($editingSchema['attributes'] as $attr)
                        <div class="form-control w-full border-b border-base-200 pb-4 mb-2 last:border-0">
                            @if($attr['type'] === 'repeater')
                                <div class="flex justify-between items-center mb-4">
                                    <label class="label"><span class="label-text font-bold text-lg text-primary">{{ $attr['label'] }}</span></label>
                                    <x-mary-button label="Añadir Item" icon="o-plus" class="btn-sm btn-outline btn-primary" wire:click="addToRepeater('{{ $attr['name'] }}')" />
                                </div>
                                <div class="space-y-4">
                                    @foreach($editingData[$attr['name']] ?? [] as $repIndex => $repItem)
                                        <div class="bg-base-200 p-4 rounded-xl relative border border-base-300 shadow-inner">
                                            <div class="absolute top-2 right-2">
                                                <x-mary-button icon="o-trash" class="btn-xs btn-circle btn-error" wire:click="removeFromRepeater('{{ $attr['name'] }}', {{ $repIndex }})" />
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                                                @foreach($attr['fields'] as $field)
                                                    <div class="form-control">
                                                        @if($field['type'] === 'image')
                                                            <label class="label-text text-xs font-bold mb-1">{{ $field['label'] }}</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="w-12 h-12 bg-neutral rounded overflow-hidden">
                                                                    @php $fieldPath = $attr['name'].'.'.$repIndex.'.'.$field['name']; @endphp
                                                                    @if(isset($uploads[$fieldPath]))
                                                                        <img src="{{ $uploads[$fieldPath]->temporaryUrl() }}" class="w-full h-full object-cover">
                                                                    @elseif(!empty($repItem[$field['name']]))
                                                                        <img src="{{ asset($repItem[$field['name']]) }}" class="w-full h-full object-cover">
                                                                    @endif
                                                                </div>
                                                                <input type="file" wire:model="uploads.{{ $fieldPath }}" class="file-input file-input-xs flex-1" />
                                                            </div>
                                                        @else
                                                            <x-mary-input label="{{ $field['label'] }}" wire:model="editingData.{{ $attr['name'] }}.{{ $repIndex }}.{{ $field['name'] }}" class="input-sm" />
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($attr['type'] === 'image')
                                <label class="label"><span class="label-text font-bold">{{ $attr['label'] }}</span></label>
                                <div class="flex items-center gap-4 p-4 bg-base-200 rounded-lg">
                                    <div class="w-20 h-20 bg-neutral rounded overflow-hidden">
                                        @if(isset($uploads[$attr['name']]))
                                            <img src="{{ $uploads[$attr['name']]->temporaryUrl() }}" class="w-full h-full object-cover">
                                        @elseif(isset($editingData[$attr['name']]) && $editingData[$attr['name']])
                                            <img src="{{ asset($editingData[$attr['name']]) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <input type="file" wire:model="uploads.{{ $attr['name'] }}" class="file-input file-input-bordered flex-1" />
                                </div>
                            @elseif($attr['type'] === 'textarea')
                                <x-mary-textarea label="{{ $attr['label'] }}" wire:model="editingData.{{ $attr['name'] }}" rows="4" />
                            @elseif($attr['type'] === 'select')
                                <x-mary-select label="{{ $attr['label'] }}" wire:model="editingData.{{ $attr['name'] }}" :options="$attr['options']" />
                            @elseif($attr['type'] === 'color')
                                <div class="flex items-center gap-3 p-3 bg-base-200 rounded-lg border border-base-300">
                                    <div class="w-10 h-10 rounded border border-white/20" style="background-color: {{ $editingData[$attr['name']] ?? 'transparent' }}"></div>
                                    <x-mary-input wire:model.live="editingData.{{ $attr['name'] }}" class="flex-1 font-mono text-xs" />
                                    <input type="color" value="{{ (isset($editingData[$attr['name']]) && str_starts_with($editingData[$attr['name']], '#')) ? substr($editingData[$attr['name']], 0, 7) : '#000000' }}" 
                                           x-on:input="$wire.set('editingData.{{ $attr['name'] }}', $event.target.value)" class="w-8 h-8" />
                                </div>
                            @elseif($attr['type'] === 'toggle')
                                <x-mary-toggle label="{{ $attr['label'] }}" wire:model="editingData.{{ $attr['name'] }}" />
                            @else
                                <x-mary-input label="{{ $attr['label'] }}" wire:model="editingData.{{ $attr['name'] }}" />
                            @endif
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
    </x-mary-modal>
</div>
