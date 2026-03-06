<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\File;
use Mary\Traits\Toast;

new #[Layout('layouts.admin')] class extends Component {
    use Toast;

    public array $settings = [];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $path = base_path('config/app_settings.json');
        if (File::exists($path)) {
            $this->settings = json_decode(File::get($path), true);
        }
    }

    public function save()
    {
        try {
            $path = base_path('config/app_settings.json');
            
            // Ensure numbers are stored as numbers and booleans as booleans
            // PHP's json_decode/encode usually handles this if types are preserved in the array
            
            File::put($path, json_encode($this->settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            $this->success('Configuración guardada correctamente.');
        } catch (\Exception $e) {
            $this->error('Error al guardar la configuración: ' . $e->getMessage());
        }
    }

    /**
     * Helper to format labels from keys (e.g., 'validity_days' -> 'Validity Days')
     */
    public function formatLabel($key)
    {
        return str_replace('_', ' ', ucfirst($key));
    }
}; ?>

<div>
    <x-mary-header title="Configuración del Sistema" subtitle="Administra los parámetros globales de la aplicación" separator>
        <x-slot:actions>
            <x-mary-button label="Guardar Cambios" icon="o-check" class="btn-primary" wire:click="save" spinner="save" />
        </x-slot:actions>
    </x-mary-header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($settings as $section => $values)
            <x-mary-card :title="$this->formatLabel($section)" shadow separator>
                <div class="space-y-4">
                    @foreach($values as $key => $value)
                        <div class="flex flex-col gap-1">
                            @if(is_bool($value))
                                <x-mary-toggle 
                                    :label="$this->formatLabel($key)" 
                                    wire:model="settings.{{ $section }}.{{ $key }}" 
                                    tight 
                                />
                            @elseif(is_numeric($value))
                                <x-mary-input 
                                    :label="$this->formatLabel($key)" 
                                    wire:model="settings.{{ $section }}.{{ $key }}" 
                                    type="number" 
                                />
                            @else
                                <x-mary-input 
                                    :label="$this->formatLabel($key)" 
                                    wire:model="settings.{{ $section }}.{{ $key }}" 
                                />
                            @endif
                        </div>
                    @endforeach
                </div>
            </x-mary-card>
        @endforeach
    </div>

    <div class="mt-8 flex justify-end bg-base-100 p-4 rounded-xl shadow-sm border border-base-200">
        <x-mary-button label="Guardar todas las secciones" icon="o-check" class="btn-primary" wire:click="save" spinner="save" />
    </div>
</div>
