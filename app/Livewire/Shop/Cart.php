<?php

namespace App\Livewire\Shop;

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Mary\Traits\Toast;

class Cart extends Component
{
    use Toast;

    #[Layout('layouts.frontend')] 
    public $cart = [];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function removeItem($uniqueId)
    {
        if (isset($this->cart[$uniqueId])) {
            unset($this->cart[$uniqueId]);
            session()->put('cart', $this->cart);
            $this->dispatch('cart-updated'); // Optional: Update header cart count if exists
            $this->success('Producto eliminado del carrito');
        }
    }

    public function incrementQuantity($uniqueId)
    {
        if (isset($this->cart[$uniqueId])) {
            $this->cart[$uniqueId]['quantity']++;
            session()->put('cart', $this->cart);
        }
    }

    public function decrementQuantity($uniqueId)
    {
        if (isset($this->cart[$uniqueId])) {
            if ($this->cart[$uniqueId]['quantity'] > 1) {
                $this->cart[$uniqueId]['quantity']--;
            } else {
                $this->removeItem($uniqueId);
                return;
            }
            session()->put('cart', $this->cart);
        }
    }

    public function getTotalProperty()
    {
        return collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            $this->error('El carrito está vacío');
            return;
        }
        
        return redirect()->route('checkout.cart');
    }

    public function render()
    {
        return view('livewire.shop.cart', [
            'cartItems' => $this->cart,
            'total' => $this->total
        ]);
    }
}
