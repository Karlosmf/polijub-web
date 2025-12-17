<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Livewire\Attributes\On;

class FloatingCartBubble extends Component
{
    public int $cartCount = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    #[On('product-added-to-cart')]
    #[On('cart-updated')]
    public function updateCartCount()
    {
        $cart = session()->get('cart', []);
        $this->cartCount = array_sum(array_column($cart, 'quantity'));
    }

    public function render()
    {
        return view('livewire.layout.floating-cart-bubble');
    }
}
