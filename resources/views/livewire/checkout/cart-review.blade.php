<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    public $cartItems = [];

    public function mount()
    {
        $this->cartItems = session()->get('cart', []);
    }

    public function increment($id)
    {
        if (isset($this->cartItems[$id])) {
            $this->cartItems[$id]['quantity']++;
            session()->put('cart', $this->cartItems);
            $this->dispatch('cart-updated');
        }
    }

    public function decrement($id)
    {
        if (isset($this->cartItems[$id]) && $this->cartItems[$id]['quantity'] > 1) {
            $this->cartItems[$id]['quantity']--;
            session()->put('cart', $this->cartItems);
            $this->dispatch('cart-updated');
        }
    }

    public function remove($id)
    {
        unset($this->cartItems[$id]);
        session()->put('cart', $this->cartItems);
        $this->dispatch('cart-updated');
    }

    public function continueToCheckout()
    {
        $this->redirect(route('checkout.delivery'), navigate: true);
    }

    public function with()
    {
        $subtotal = array_reduce($this->cartItems, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
        return [
            'subtotal' => $subtotal,
            'total' => $subtotal, // Assuming free shipping and no tax for now
        ];
    }
}; ?>

<div class="font-sans text-gray-900 bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col">
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <style>
        .font-display { font-family: 'Poppins', sans-serif; }
    </style>

    <div class="flex-grow container mx-auto px-4 py-12">
        <div class="text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-bold text-[#14b8a6] mb-2 font-display">Carrito de Compras</h1>
            <p class="text-gray-500 dark:text-gray-400 text-lg">Revisá tus productos antes de finalizar la compra.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items -->
            <div class="lg:w-2/3 space-y-6">
                @if(count($cartItems) > 0)
                    @foreach($cartItems as $item)
                    <div wire:key="{{ $item['id'] }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex flex-col sm:flex-row items-center gap-6 transition-colors duration-200 border border-gray-100 dark:border-gray-700">
                        <div class="w-full sm:w-32 h-32 bg-blue-100 rounded-lg overflow-hidden flex-shrink-0 relative group">
                            <img alt="{{ $item['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="{{ $item['image'] }}" />
                            <!-- Mock Badge -->
                            <span class="absolute top-2 left-2 bg-blue-200 text-blue-800 text-xs font-bold px-2 py-0.5 rounded">3 sabores</span>
                        </div>
                        <div class="flex-grow text-center sm:text-left">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-1 font-display">{{ $item['name'] }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ $item['description'] }}</p>
                            <div class="flex items-center justify-center sm:justify-start gap-2">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-medium">
                                    <span class="material-icons text-xs">local_shipping</span> Delivery
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center sm:items-end gap-3">
                            <span class="text-2xl font-bold text-[#14b8a6]">${{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</span>
                            <div class="flex items-center gap-3 bg-gray-100 dark:bg-gray-700 rounded-full px-3 py-1">
                                <button wire:click="decrement({{ $item['id'] }})" class="w-8 h-8 rounded-full bg-white dark:bg-gray-600 text-gray-500 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-500 flex items-center justify-center shadow-sm transition-colors">
                                    <span class="material-icons text-sm">remove</span>
                                </button>
                                <span class="font-semibold text-gray-800 dark:text-gray-200 w-4 text-center">{{ $item['quantity'] }}</span>
                                <button wire:click="increment({{ $item['id'] }})" class="w-8 h-8 rounded-full bg-white dark:bg-gray-600 text-[#14b8a6] hover:bg-gray-200 dark:hover:bg-gray-500 flex items-center justify-center shadow-sm transition-colors">
                                    <span class="material-icons text-sm">add</span>
                                </button>
                            </div>
                            <button wire:click="remove({{ $item['id'] }})" class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center gap-1 mt-1 transition-colors">
                                <span class="material-icons text-sm">delete_outline</span> Eliminar
                            </button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-10 text-center">
                        <span class="material-icons text-6xl text-gray-300 mb-4">shopping_cart_off</span>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">Tu carrito está vacío</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">Parece que no has agregado ningún producto todavía.</p>
                        <a href="{{ route('shop.products') }}" class="bg-[#14b8a6] hover:bg-[#0d9488] text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-colors">
                            Ir a la Tienda
                        </a>
                    </div>
                @endif

                <div class="mt-6">
                    <a class="text-[#14b8a6] hover:text-[#0d9488] font-semibold flex items-center gap-2 transition-colors" href="{{ route('shop.products') }}">
                        <span class="material-icons text-lg">arrow_back</span> Seguir Comprando
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 sticky top-24 border border-gray-100 dark:border-gray-700 transition-colors duration-200">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 border-b border-gray-200 dark:border-gray-700 pb-4 font-display">Resumen del Pedido</h2>
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center text-gray-500 dark:text-gray-400">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200">${{ number_format($subtotal, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-500 dark:text-gray-400">
                            <span>Envío</span>
                            <span class="text-green-600 font-medium">Gratis</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-500 dark:text-gray-400">
                            <span>Impuestos</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200">$0,00</span>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide" for="coupon">Código de Descuento</label>
                        <div class="flex gap-2">
                            <input class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent outline-none transition-all placeholder-gray-400" id="coupon" placeholder="Ingresá tu cupón" type="text"/>
                            <button class="bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">Aplicar</button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-800 dark:text-gray-200 font-display">Total</span>
                            <span class="text-3xl font-bold text-[#14b8a6]">${{ number_format($total, 2, ',', '.') }}</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-right">IVA incluido en todos los precios.</p>
                    </div>
                    @if(count($cartItems) > 0)
                        <button wire:click="continueToCheckout" class="w-full bg-[#14b8a6] hover:bg-[#0d9488] text-white font-bold py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                            Continuar al Pago
                            <span class="material-icons">arrow_forward</span>
                        </button>
                    @else
                        <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-4 rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                            Continuar al Pago
                            <span class="material-icons">arrow_forward</span>
                        </button>
                    @endif
                    <div class="mt-6 flex justify-center gap-4 text-gray-400">
                        <span class="material-icons text-3xl">credit_card</span>
                        <span class="material-icons text-3xl">account_balance</span>
                        <span class="material-icons text-3xl">qr_code_2</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <x-footer />
</div>
