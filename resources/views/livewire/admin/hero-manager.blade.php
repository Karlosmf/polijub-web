<?php
/**
 * Hero Manager Volt Component
 * Allows administrators to update the Hero Section promotion details.
 */

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Mary\Traits\Toast;

new #[Layout('layouts.admin')] class extends Component {
    use WithFileUploads, Toast;

    public $promotion = [];
    public $image;
    public $new_overlay_images = []; // Array for new image uploads

    public function mount()
    {
        $this->loadPromotion();
    }

    public function loadPromotion()
    {
        $path = storage_path('app/public/hero/promotion.json');
        if (File::exists($path)) {
            $this->promotion = json_decode(File::get($path), true);
        } else {
            // Default values
            $this->promotion = [
                'title' => '#LOQUEQUIERAS',
                'description' => 'Para este #MESDELAMOR preparamos un montón de cosas ricas para disfrutar con todo el amor...,',
                'subtitle' => 'EL AMOR POR EL HELADO!!!',
                'button_text' => 'Ver más',
                'button_url' => '#',
                'image_path' => 'images/nuevospng/petalos.webp',
                'secondary_image_path' => 'heroimg.gif',
                'title_color' => '#fe0196',
                'subtitle_color' => '#fe0196',
                'bg_color' => '#DCD7CA',
                'show_subtitle' => true,
                'show_button' => true,
                'content_alignment' => 'justify-end',
                'vertical_alignment' => 'items-center',
                'overlays' => [] // Initialize empty array
            ];
            $this->savePromotion();
        }

        // Ensure overlays key exists for older JSONs
        if (!isset($this->promotion['overlays'])) {
            $this->promotion['overlays'] = [];
        }
    }

    public function addOverlay()
    {
        if (!isset($this->promotion['overlays'])) {
            $this->promotion['overlays'] = [];
        }
        $this->promotion['overlays'][] = [
            'image_path' => '',
            'position_x' => '50',
            'position_y' => '50',
            'is_visible' => true
        ];
    }

    public function removeOverlay($index)
    {
        unset($this->promotion['overlays'][$index]);
        $this->promotion['overlays'] = array_values($this->promotion['overlays']);
    }

    public function save()
    {
        if ($this->image) {
            $imageName = 'hero_' . time() . '.' . $this->image->getClientOriginalExtension();
            $this->promotion['image_path'] = $this->image->storeAs('hero', $imageName, 'public');
        }

        // Process new overlay image uploads
        if (isset($this->promotion['overlays'])) {
            foreach ($this->promotion['overlays'] as $index => $overlay) {
                if (isset($this->new_overlay_images[$index])) {
                    $file = $this->new_overlay_images[$index];
                    $imageName = 'overlay_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                    $this->promotion['overlays'][$index]['image_path'] = $file->storeAs('hero', $imageName, 'public');
                }
            }
        }
        
        // Clear uploaded files array after processing so they don't upload again
        $this->new_overlay_images = [];

        $this->savePromotion();
        $this->success('Promoción de Hero guardada correctamente.');
    }

    private function savePromotion()
    {
        $path = storage_path('app/public/hero/promotion.json');
        File::ensureDirectoryExists(dirname($path));
        File::put($path, json_encode($this->promotion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}; ?>

<div>
    <x-mary-header title="Gestión de Hero" subtitle="Configura la promoción principal de la página de inicio" separator>
        <x-slot:actions>
            <x-mary-button label="Guardar Cambios" icon="o-check" class="btn-primary" wire:click="save" spinner="save" />
        </x-slot:actions>
    </x-mary-header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-mary-card title="Contenido de Texto" shadow separator>
            <div class="space-y-4">
                <x-mary-input label="Título Principal" wire:model="promotion.title" placeholder="#LOQUEQUIERAS" />
                
                <div class="p-4 bg-base-200/50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold">Subtítulo</span>
                        <x-mary-toggle wire:model="promotion.show_subtitle" tight />
                    </div>
                    <div x-show="$wire.promotion.show_subtitle">
                        <x-mary-input wire:model="promotion.subtitle" />
                    </div>
                </div>

                <x-mary-textarea label="Descripción" wire:model="promotion.description" placeholder="Texto descriptivo..." />
                
                <div class="p-4 bg-base-200/50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold">Botón</span>
                        <x-mary-toggle wire:model="promotion.show_button" tight />
                    </div>
                    <div class="grid grid-cols-2 gap-4" x-show="$wire.promotion.show_button">
                        <x-mary-input label="Texto" wire:model="promotion.button_text" />
                        <x-mary-input label="Enlace (URL)" wire:model="promotion.button_url" />
                    </div>
                </div>
            </div>
        </x-mary-card>

        <x-mary-card title="Diseño y Colores" shadow separator>
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-base-200/50 rounded-lg">
                        <h3 class="font-bold mb-3 text-sm text-gray-500">Alineación Horizontal</h3>
                        <x-mary-radio wire:model="promotion.content_alignment" :options="[
                            ['id' => 'justify-start', 'name' => 'Izquierda'],
                            ['id' => 'justify-center', 'name' => 'Centro'],
                            ['id' => 'justify-end', 'name' => 'Derecha']
                        ]" />
                    </div>

                    <div class="p-4 bg-base-200/50 rounded-lg">
                        <h3 class="font-bold mb-3 text-sm text-gray-500">Alineación Vertical</h3>
                        <x-mary-radio wire:model="promotion.vertical_alignment" :options="[
                            ['id' => 'items-start', 'name' => 'Arriba'],
                            ['id' => 'items-center', 'name' => 'Medio'],
                            ['id' => 'items-end', 'name' => 'Abajo']
                        ]" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <x-mary-colorpicker label="Color Título" placeholder="#fe0196 o rgba(0,0,0,0)" wire:model="promotion.title_color" />
                    <x-mary-colorpicker label="Color Subtítulo" placeholder="#fe0196 o rgba(0,0,0,0)" wire:model="promotion.subtitle_color" />
                    <x-mary-colorpicker label="Color Fondo (Capa texto)" placeholder="rgba(220, 215, 202, 0.9) o transparente" wire:model="promotion.bg_color" />
                </div>

                <div class="divider">Imágenes</div>

                <div class="space-y-4">
                    <div>
                        <x-mary-file label="Imagen Principal (Producto)" wire:model="image" accept="image/*" />
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="h-32 w-full object-contain mt-2 bg-gray-100 rounded">
                        @elseif ($promotion['image_path'])
                            @php
                                $imgSrc = str_starts_with($promotion['image_path'], 'images/') 
                                    ? asset($promotion['image_path']) 
                                    : asset('storage/' . $promotion['image_path']);
                            @endphp
                            <img src="{{ $imgSrc }}" class="h-32 w-full object-contain mt-2 bg-gray-100 rounded">
                        @endif
                    </div>

                    <div class="p-4 bg-base-200/50 rounded-lg">
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-bold text-lg">Imágenes Superpuestas (Overlays)</span>
                            <x-mary-button label="Agregar Overlay" icon="o-plus" class="btn-sm btn-primary" wire:click="addOverlay" />
                        </div>
                        
                        <div class="space-y-6">
                            @foreach($promotion['overlays'] ?? [] as $index => $overlay)
                            <div class="p-4 border border-dashed border-gray-300 rounded-lg relative bg-white" wire:key="overlay-{{ $index }}">
                                <div class="absolute top-2 right-2 flex gap-2">
                                    <x-mary-toggle wire:model="promotion.overlays.{{ $index }}.is_visible" tight tooltip="Visibilidad" />
                                    <x-mary-button icon="o-trash" class="btn-sm btn-error btn-circle" wire:click="removeOverlay({{ $index }})" tooltip="Eliminar" />
                                </div>
                                
                                <h4 class="font-semibold mb-3">Overlay #{{ $index + 1 }}</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-mary-file label="Subir Imagen" wire:model="new_overlay_images.{{ $index }}" accept="image/*" />
                                        @if (isset($new_overlay_images[$index]))
                                            <img src="{{ $new_overlay_images[$index]->temporaryUrl() }}" class="h-20 w-auto object-contain mt-2 bg-gray-100 rounded">
                                        @elseif (!empty($overlay['image_path']))
                                            @php
                                                $overlaySrc = str_contains($overlay['image_path'], '.') 
                                                    ? (str_starts_with($overlay['image_path'], 'hero/') ? asset('storage/' . $overlay['image_path']) : asset($overlay['image_path']))
                                                    : asset($overlay['image_path']);
                                            @endphp
                                            <img src="{{ $overlaySrc }}" class="h-20 w-auto object-contain mt-2 bg-gray-100 rounded">
                                        @endif
                                    </div>
                                    <div class="space-y-2">
                                        <x-mary-input label="Posición Horizontal X (%)" type="number" wire:model="promotion.overlays.{{ $index }}.position_x" hint="Ej: 50 (centro), 0 (izquierda), 100 (derecha)" />
                                        <x-mary-input label="Posición Vertical Y (%)" type="number" wire:model="promotion.overlays.{{ $index }}.position_y" hint="Ej: 50 (centro), 0 (arriba), 100 (abajo)" />
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            @if(count($promotion['overlays'] ?? []) === 0)
                                <div class="text-center text-gray-500 py-4">No hay overlays configurados. Pulsa "Agregar Overlay" para comenzar.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </x-mary-card>
    </div>

    <div class="mt-8 flex justify-end">
        <x-mary-button label="Guardar Todo" icon="o-check" class="btn-primary" wire:click="save" spinner="save" />
    </div>
</div>
