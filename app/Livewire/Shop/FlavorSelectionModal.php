<?php

namespace App\Livewire\Shop;

use App\Models\Flavor;
use Livewire\Component;
use Livewire\Attributes\On;

class FlavorSelectionModal extends Component
{
    public bool $modalOpen = false;
    public int $productId = 0;
    public string $productName = '';
    public int $quantity = 1;
    public int $maxFlavors = 0;
    
    public array $selectedFlavors = [];
    public $flavors;

    public function mount()
    {
        $this->flavors = Flavor::where('is_active', true)->orderBy('name')->get();
    }

    #[On('open-flavor-modal')]
    public function open(int $productId, string $productName, int $quantity, int $maxFlavors)
    {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->maxFlavors = $maxFlavors;
        $this->selectedFlavors = [];
        $this->modalOpen = true;
    }

    public function toggleFlavor(int $flavorId)
    {
        if (in_array($flavorId, $this->selectedFlavors)) {
            $this->selectedFlavors = array_diff($this->selectedFlavors, [$flavorId]);
        } else {
            if (count($this->selectedFlavors) < $this->maxFlavors) {
                $this->selectedFlavors[] = $flavorId;
            }
        }
    }

    public function confirm()
    {
        if (count($this->selectedFlavors) === 0 && $this->maxFlavors > 0) {
            // Optional: enforce at least one flavor? Or maybe allow empty if they want "Surprise me"?
            // For now let's assume they must select at least one if max > 0
             $this->dispatch('toast', message: 'Selecciona al menos un sabor.', type: 'error');
             return;
        }

        $this->dispatch('add-to-cart-with-flavors', productId: $this->productId, flavors: $this->selectedFlavors);
        $this->modalOpen = false;
    }

    public function render()
    {
        return view('livewire.shop.flavor-selection-modal');
    }
}
