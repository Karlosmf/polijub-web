<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\File;
use Mary\Traits\Toast;

new #[Layout('layouts.admin')] class extends Component {
    use Toast;

    public array $settings = [];
    public array $dayNames = [
        'mon' => 'Lunes',
        'tue' => 'Martes',
        'wed' => 'Miércoles',
        'thu' => 'Jueves',
        'fri' => 'Viernes',
        'sat' => 'Sábado',
        'sun' => 'Domingo',
    ];

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
                    @if($section === 'shopping_hours')
                        {{-- ... (código existente para shopping_hours) --}}
                        <div class="mb-4 pb-4 border-b">
                            <x-mary-toggle label="Habilitar Restricción Horaria" wire:model="settings.shopping_hours.enabled" tight />
                        </div>
                        
                        <div class="space-y-6">
                            @foreach($dayNames as $code => $name)
                                <div class="p-3 bg-base-200/50 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-bold">{{ $name }}</span>
                                        <x-mary-toggle wire:model="settings.shopping_hours.schedule.{{ $code }}.enabled" tight />
                                    </div>
                                    <div class="grid grid-cols-2 gap-2" x-show="$wire.settings.shopping_hours.schedule.{{ $code }}.enabled">
                                        <x-mary-input label="Desde" wire:model="settings.shopping_hours.schedule.{{ $code }}.start_time" type="time" />
                                        <x-mary-input label="Hasta" wire:model="settings.shopping_hours.schedule.{{ $code }}.end_time" type="time" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @elseif($section === 'referrals')
                        <x-mary-toggle label="Habilitar Referidos" wire:model="settings.referrals.enabled" tight />
                        
                        <div class="mt-4 p-4 bg-base-200/30 rounded-lg border border-base-200">
                            <h3 class="font-bold mb-3 text-primary flex items-center gap-2">
                                <x-mary-icon name="o-user-plus" class="w-4 h-4" /> Beneficio Nuevo Usuario
                            </h3>
                            <div class="grid grid-cols-1 gap-3">
                                <x-mary-select label="Tipo" wire:model="settings.referrals.new_user_benefit.type" :options="[['id' => 'percentage', 'name' => 'Porcentaje'], ['id' => 'fixed_amount', 'name' => 'Monto Fijo']]" />
                                <x-mary-input label="Valor" wire:model="settings.referrals.new_user_benefit.value" type="number" />
                                <x-mary-input label="Días Validez" wire:model="settings.referrals.new_user_benefit.validity_days" type="number" />
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-base-200/30 rounded-lg border border-base-200">
                            <h3 class="font-bold mb-3 text-secondary flex items-center gap-2">
                                <x-mary-icon name="o-share" class="w-4 h-4" /> Beneficio Referente
                            </h3>
                            <div class="grid grid-cols-1 gap-3">
                                <x-mary-select label="Tipo" wire:model="settings.referrals.referrer_benefit.type" :options="[['id' => 'percentage', 'name' => 'Porcentaje'], ['id' => 'fixed_amount', 'name' => 'Monto Fijo']]" />
                                <x-mary-input label="Valor" wire:model="settings.referrals.referrer_benefit.value" type="number" />
                                <x-mary-input label="Días Validez" wire:model="settings.referrals.referrer_benefit.validity_days" type="number" />
                            </div>
                        </div>
                        <x-mary-input label="Descripción" wire:model="settings.referrals.description" />
                    @else
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
                    @endif
                </div>
            </x-mary-card>
        @endforeach
    </div>

    <div class="mt-8 flex justify-end bg-base-100 p-4 rounded-xl shadow-sm border border-base-200">
        <x-mary-button label="Guardar todas las secciones" icon="o-check" class="btn-primary" wire:click="save" spinner="save" />
    </div>
</div>
