<?php

use Livewire\Volt\Component;
use App\Models\Flavor;
use App\Models\Tag;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component {
    use WithPagination;

    public string $search = '';

    public function with(): array
    {
        return [
            'flavors' => Flavor::with('tags')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ];
    }
}; ?>

<div>
    <x-mary-header title="Administrar Sabores" subtitle="Gestión de gustos de helado" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Buscar sabor..." wire:model.live.debounce="search" />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-plus" class="btn-primary" link="{{ route('admin.flavors.create') }}" label="Nuevo Sabor" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table :headers="[
        ['key' => 'id', 'label' => '#'],
        ['key' => 'image', 'label' => 'Imagen'],
        ['key' => 'name', 'label' => 'Nombre'],
        ['key' => 'tags', 'label' => 'Categorías'],
        ['key' => 'is_active', 'label' => 'Activo']
    ]" :rows="$flavors" :link="route('admin.flavors.edit', ['id' => '[id]'])" striped>
        
        @scope('cell_image', $flavor)
            <div class="avatar">
                <div class="w-12 rounded">
                    @if(str_starts_with($flavor->image, 'http'))
                        <img src="{{ $flavor->image }}" onerror="this.onerror=null;this.src='/images/default.webp';" />
                    @elseif(str_starts_with($flavor->image, 'images/') || str_starts_with($flavor->image, 'imgs/'))
                        <img src="{{ '/' . $flavor->image }}" onerror="this.onerror=null;this.src='/images/default.webp';" />
                    @elseif(!str_contains($flavor->image, '/'))
                        <img src="{{ '/images/' . $flavor->image }}" onerror="this.onerror=null;this.src='/images/default.webp';" />
                    @else
                        <img src="{{ '/imgs/' . $flavor->image }}" onerror="this.onerror=null;this.src='/images/default.webp';" />
                    @endif
                </div>
            </div>
        @endscope

        @scope('cell_tags', $flavor)
            <div class="flex flex-wrap gap-1">
                @foreach($flavor->tags as $tag)
                    <x-badge :value="$tag->name" class="text-white" style="background-color: {{ $tag->color }}" />
                @endforeach
            </div>
        @endscope

        @scope('cell_is_active', $flavor)
            @if($flavor->is_active)
                <x-badge value="Activo" class="badge-success" />
            @else
                <x-badge value="Inactivo" class="badge-ghost" />
            @endif
        @endscope

    </x-table>

    <div class="mt-4">
        {{ $flavors->links() }}
    </div>
</div>
