<?php

use Illuminate\Support\Facades\Str;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Mary\Traits\Toast;

new #[Layout('layouts.admin')] class extends Component {
    use WithFileUploads, Toast;

    public $carousels = [];
    public $showModal = false;
    public $isEdit = false;
    public $slide_id;
    public $image_path, $title, $description, $url, $url_text, $image;

    private function getSlides()
    {
        if (Storage::disk('public')->exists('carousel/slides.json')) {
            $json = Storage::disk('public')->get('carousel/slides.json');
            $slides = json_decode($json, true);
            return is_array($slides) ? $slides : [];
        }
        return [];
    }

    private function saveSlides(array $slides)
    {
        Storage::disk('public')->put('carousel/slides.json', json_encode($slides, JSON_PRETTY_PRINT));
    }

    public function mount()
    {
        $this->carousels = $this->getSlides();
    }

    public function create()
    {
        $this->isEdit = false;
        $this->reset(['image_path', 'title', 'description', 'url', 'url_text', 'slide_id', 'image']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $slide = collect($this->carousels)->firstWhere('id', $id);
        if ($slide) {
            $this->slide_id = $id;
            $this->image_path = $slide['image_path'];
            $this->title = $slide['title'];
            $this->description = $slide['description'];
            $this->url = $slide['url'];
            $this->url_text = $slide['url_text'];
            $this->isEdit = true;
            $this->showModal = true;
            $this->image = null;
        }
    }

    public function save()
    {
        $slides = $this->getSlides();
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'url_text' => $this->url_text,
        ];

        if ($this->image) {
            // Delete old image if it exists
            if ($this->isEdit && $this->image_path) {
                Storage::disk('public')->delete($this->image_path);
            }
            $imageName = time() . '-' . Str::random(8) . '.' . $this->image->getClientOriginalExtension();
            $data['image_path'] = $this->image->storeAs('carousel', $imageName, 'public');
        } else {
            $data['image_path'] = $this->image_path;
        }

        if ($this->isEdit) {
            $index = collect($slides)->search(fn($s) => $s['id'] == $this->slide_id);
            if ($index !== false) {
                $slides[$index] = array_merge($slides[$index], $data);
            }
        } else {
            $data['id'] = (string) Str::uuid();
            $slides[] = $data;
        }

        $this->saveSlides($slides);
        $this->carousels = $this->getSlides();
        $this->showModal = false;
        $this->success('Slide saved successfully.');
    }

    public function delete($id)
    {
        $slides = $this->getSlides();
        $index = collect($slides)->search(fn($s) => $s['id'] == $id);

        if ($index !== false) {
            // Delete image from storage
            if (!empty($slides[$index]['image_path'])) {
                Storage::disk('public')->delete($slides[$index]['image_path']);
            }
            array_splice($slides, $index, 1);
            $this->saveSlides($slides);
            $this->carousels = $this->getSlides();
            $this->success('Slide deleted successfully.');
        }
    }

    public function updateOrder($orderedSlides)
    {
        $slides = $this->getSlides();
        $lookup = collect($slides)->keyBy('id');
        $newOrder = [];
        foreach($orderedSlides as $slide) {
            if(isset($lookup[$slide['value']])){
                $newOrder[] = $lookup[$slide['value']];
            }
        }

        $this->saveSlides($newOrder);
        $this->carousels = $this->getSlides();
        $this->success('Slides reordered successfully.');
    }
}; ?>

<div x-data="{}" x-init="$nextTick(() => {
    if (typeof Sortable !== 'undefined') {
        new Sortable($refs.imageList, {
            animation: 200,
            handle: '.handle', // Drag handle
            onEnd: function (evt) {
                const orderedIds = Array.from(evt.to.children).map(item => ({ value: item.dataset.id }));
                @this.call('updateOrder', orderedIds);
            },
        });
    } else {
        console.warn('SortableJS not loaded');
    }
})">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <x-mary-header title="Carousel Manager" separator>
        <x-slot:actions>
            <x-mary-button label="Add Slide" wire:click="create" class="btn-primary" />
        </x-slot:actions>
    </x-mary-header>

    <div class="relative">
        <div wire:loading.flex wire:target="updateOrder" class="absolute inset-0 bg-white bg-opacity-75 z-10 items-center justify-center" style="display: none;">
            <div class="text-center">
                <x-mary-icon name="o-arrow-path" class="w-8 h-8 animate-spin mx-auto" />
                <p>Reordenando imágenes...</p>
            </div>
        </div>
        <div x-ref="imageList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" wire:loading.class="opacity-50" wire:target="updateOrder">
            @foreach($carousels as $slide)
            <div wire:key="{{ $slide['id'] }}" data-id="{{ $slide['id'] }}"
                    class="relative group bg-base-200 rounded-lg shadow-md">
                    <img src="{{ asset('storage/' . $slide['image_path']) }}" alt="{{ $slide['title'] }}" class="h-48 w-full object-cover rounded-lg">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button class="handle cursor-grab text-white p-2 rounded-full mr-2">
                            <x-mary-icon name="o-arrows-pointing-out" class="w-6 h-6" />
                        </button>
                        <x-mary-button icon="o-pencil" wire:click.stop="edit('{{ $slide['id'] }}')" class="btn-sm" />
                        <x-mary-button icon="o-trash" wire:click="delete('{{ $slide['id'] }}')" wire:confirm="Are you sure?" class="btn-sm text-red-500 bg-white" />
                    </div>
                    <div class="absolute bottom-2 left-2 text-white text-sm bg-black bg-opacity-70 px-2 py-1 rounded">
                        {{ $slide['title'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <x-mary-modal wire:model="showModal" title="{{ $isEdit ? 'Edit Slide' : 'Add new slide' }}">
        <x-mary-form wire:submit.prevent="save">
            <x-mary-file label="Image" wire:model="image" accept="image/*" />
            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" class="h-20 w-20 object-cover mt-2">
            @elseif ($image_path)
                <img src="{{ asset('storage/' . $image_path) }}" class="h-20 w-20 object-cover mt-2">
            @endif
            <x-mary-input label="Title" wire:model="title" />
            <x-mary-textarea label="Description" wire:model="description" />
            <x-mary-input label="URL" wire:model="url" />
            <x-mary-input label="URL Text" wire:model="url_text" />

            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.showModal = false" />
                <x-mary-button label="Save" type="submit" class="btn-primary" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>