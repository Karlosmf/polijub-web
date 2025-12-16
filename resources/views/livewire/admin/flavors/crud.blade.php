<?php

use Livewire\Volt\Component;
use App\Models\Flavor;
use App\Models\Tag;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Mary\Traits\Toast;
use Illuminate\Support\Str;

new #[Layout('layouts.admin')] class extends Component {
    use WithFileUploads, Toast;

    public bool $isEditing = false;
    public $flavorId;
    
    #[Rule('required|min:3')]
    public string $name = '';

    #[Rule('nullable|string')]
    public string $description = '';

    #[Rule('nullable|image|max:1024')] // 1MB Max
    public $image;
    public $imageUrl;

    #[Rule('array')]
    public array $tags = []; // Selected Tag IDs

    public bool $is_active = true;

    public function mount($id = null)
    {
        if ($id) {
            $flavor = Flavor::findOrFail($id);
            $this->isEditing = true;
            $this->flavorId = $flavor->id;
            $this->name = $flavor->name;
            $this->description = $flavor->description ?? '';
            $this->is_active = $flavor->is_active;

            if (str_starts_with($flavor->image, 'http')) {
                $this->imageUrl = $flavor->image;
            } elseif (str_starts_with($flavor->image, 'images/') || str_starts_with($flavor->image, 'imgs/')) {
                $this->imageUrl = '/' . $flavor->image;
            } elseif (!str_contains($flavor->image, '/')) {
                $this->imageUrl = '/images/' . $flavor->image;
            } else {
                $this->imageUrl = '/imgs/' . $flavor->image;
            }

            $this->tags = $flavor->tags->pluck('id')->toArray();
        } else {
            $this->isEditing = false;
            $this->is_active = true;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            $filename = $this->image->store('flavors', 'app_public_imgs'); 
            $data['image'] = $filename;
        }

        if ($this->isEditing) {
            $flavor = Flavor::find($this->flavorId);
            if (!$this->image) {
                unset($data['image']); 
            }
            $flavor->update($data);
            $flavor->tags()->sync($this->tags);
            $this->success('Sabor actualizado correctamente.', redirectTo: route('admin.flavors'));
        } else {
            if (!$this->image) {
                $data['image'] = 'images/default.webp'; // Fallback
            }
            $flavor = Flavor::create($data);
            $flavor->tags()->sync($this->tags);
            $this->success('Sabor creado correctamente.', redirectTo: route('admin.flavors'));
        }
    }

    public function delete()
    {
        if ($this->flavorId) {
            Flavor::destroy($this->flavorId);
            $this->success('Sabor eliminado.', redirectTo: route('admin.flavors'));
        }
    }
    
    public function with(): array
    {
        return [
            'availableTags' => Tag::orderBy('name')->get()
        ];
    }
}; ?>

<div>
    <x-header :title="$isEditing ? 'Editar Sabor' : 'Nuevo Sabor'" separator />

    <form wire:submit="save" id="flavor-form">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <x-input label="Nombre del Gusto" wire:model="name" placeholder="Ej: Chocolate Suizo" />
                
                <x-textarea label="Descripción" wire:model="description" placeholder="Breve descripción del sabor..." rows="3" />
                
                {{-- Multi-select for Tags --}}
                <x-choices label="Categorías" wire:model="tags" :options="$availableTags" option-label="name" option-value="id" searchable />
            </div>

            <div class="space-y-4">
                <div class="card bg-base-200 p-4">
                    <h4 class="font-bold mb-2 text-sm uppercase text-gray-500">Imagen</h4>
                    <x-file wire:model="image" accept="image/png, image/jpeg, image/webp">
                        <div class="flex items-center gap-4">
                            <img src="{{ $image ? $image->temporaryUrl() : ($imageUrl ?: '/images/default.webp') }}" class="h-20 w-20 rounded-lg object-cover border" onerror="this.onerror=null;this.src='/images/default.webp';" />
                            <div class="text-sm text-gray-500">
                                <span class="block">Formatos: JPG, PNG, WEBP</span>
                                <span class="block">Max: 1MB</span>
                            </div>
                        </div>
                    </x-file>
                </div>

                <x-toggle label="Sabor Activo" wire:model="is_active" right />
            </div>
        </div>
    
        <div class="flex justify-between items-center mt-6">
            <div>
                @if($isEditing)
                    <x-button label="Eliminar" icon="o-trash" wire:click="delete" wire:confirm="¿Estás seguro de eliminar este sabor?" class="btn-error btn-ghost" />
                @endif
            </div>
            <div class="flex gap-2">
                <x-button label="Cancelar" link="{{ route('admin.flavors') }}" />
                <x-button label="Guardar" class="btn-primary" type="submit" spinner="save" form="flavor-form" />
            </div>
        </div>
    </form>
</div>