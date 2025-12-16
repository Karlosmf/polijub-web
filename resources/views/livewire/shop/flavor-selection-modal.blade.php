<?php

use Livewire\Volt\Component;
use App\Models\Flavor;
use App\Models\Product;
use Mary\Traits\Toast;
use Livewire\Attributes\On;

new class extends Component {
    use Toast;

    public $showModal = false;
    public $productId;
    public $productName;
    public $productQuantity;
    public $maxFlavors;
    public $availableFlavors = [];
    public $selectedFlavors = [];
    public $selectedFlavorCount = 0;

    public function mount()
    {
        $this->availableFlavors = Flavor::where('is_active', true)->get()->toArray();
    }

    #[On('open-flavor-modal')]
    public function openModal(int $productId, string $productName, int $quantity, int $maxFlavors)
    {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->productQuantity = $quantity;
        $this->maxFlavors = $maxFlavors;
        $this->selectedFlavors = []; // Reset selected flavors
        $this->selectedFlavorCount = 0;
        $this->showModal = true;
    }

    public function updatedSelectedFlavors()
    {
        $this->selectedFlavorCount = count($this->selectedFlavors);
    }

    public function addFlavorsToCart()
    {
        if ($this->selectedFlavorCount > $this->maxFlavors) {
            $this->error("No puedes seleccionar más de {$this->maxFlavors} sabores.");
            return;
        }

        // Dispatch event to ProductList to actually add to cart
        $this->dispatch('add-to-cart-with-flavors', 
            productId: $this->productId, 
            quantity: $this->productQuantity, 
            flavors: $this->selectedFlavors
        );

        $this->success("{$this->productName} agregado al carrito con los sabores seleccionados.");
        $this->showModal = false;
    }
}; ?>

<x-modal wire:model="showModal" title="Selecciona tus Sabores" subtitle="Elige hasta {{ $maxFlavors }} sabores para tu {{ $productName }}" class="!max-w-2xl">
    @if ($maxFlavors > 0)
        <div class="mb-4 text-center text-sm text-gray-600 dark:text-gray-300">
            Has seleccionado {{ $selectedFlavorCount }} de {{ $maxFlavors }} sabores.
        </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-h-96 overflow-y-auto p-2">
        @forelse ($availableFlavors as $flavor)
            <label wire:key="flavor-{{ $flavor['id'] }}" class="flex flex-col items-center p-3 border rounded-lg cursor-pointer transition-all duration-200
                {{ in_array($flavor['id'], $selectedFlavors) ? 'border-brand-primary bg-brand-primary/10 ring-2 ring-brand-primary' : 'border-gray-200 dark:border-gray-700 hover:border-brand-secondary dark:hover:border-brand-secondary bg-white dark:bg-gray-800' }}
                {{ $selectedFlavorCount >= $maxFlavors && !in_array($flavor['id'], $selectedFlavors) ? 'opacity-50 cursor-not-allowed' : '' }}
            ">
                <input
                    type="checkbox"
                    value="{{ $flavor['id'] }}"
                    wire:model.live="selectedFlavors"
                    class="sr-only"
                    {{ $selectedFlavorCount >= $maxFlavors && !in_array($flavor['id'], $selectedFlavors) ? 'disabled' : '' }}
                >
                <img src="{{ asset('images/flavors/' . $flavor['image']) }}" alt="{{ $flavor['name'] }}" class="w-20 h-20 rounded-full object-cover mb-2">
                <span class="text-sm font-semibold text-center {{ in_array($flavor['id'], $selectedFlavors) ? 'text-brand-primary dark:text-brand-primary' : 'text-gray-800 dark:text-gray-200' }}">
                    {{ $flavor['name'] }}
                </span>
                @if ($flavor['description'])
                    <span class="text-xs text-gray-500 dark:text-gray-400 text-center mt-1">{{ $flavor['description'] }}</span>
                @endif
            </label>
        @empty
            <p class="col-span-full text-center text-gray-500">No hay sabores disponibles.</p>
        @endforelse
    </div>

    <x-slot:actions>
        <x-button label="Cancelar" @click="$wire.showModal = false" />
        <x-button
            label="Agregar al Carrito"
            wire:click="addFlavorsToCart"
            class="btn-primary"
            :disabled="$selectedFlavorCount == 0 || ($selectedFlavorCount > $maxFlavors)"
        />
    </x-slot:actions>
</x-modal>
