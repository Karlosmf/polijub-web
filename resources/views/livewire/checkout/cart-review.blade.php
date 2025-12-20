<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.frontend')] class extends Component {
    public $cartItems = [];

    public function mount()
    {
        $this->cartItems = session()->get('cart', []);
    }

    public function increment($uniqueId)
    {
        if (isset($this->cartItems[$uniqueId])) {
            $this->cartItems[$uniqueId]['quantity']++;
            session()->put('cart', $this->cartItems);
            $this->dispatch('cart-updated');
        }
    }

    public function decrement($uniqueId)
    {
        if (isset($this->cartItems[$uniqueId]) && $this->cartItems[$uniqueId]['quantity'] > 1) {
            $this->cartItems[$uniqueId]['quantity']--;
            session()->put('cart', $this->cartItems);
            $this->dispatch('cart-updated');
        }
    }

    public function remove($uniqueId)
    {
        unset($this->cartItems[$uniqueId]);
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

<div>
    <div class="flex-grow container mx-auto px-4 py-12">
        <div class="text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 font-display">Carrito de Compras</h1>
            <x-checkout-steps step="1" />
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items -->
            <div class="lg:w-2/3 space-y-6">
                @if(count($cartItems) > 0)
                    @foreach($cartItems as $item)
                        <div wire:key="{{ $item['unique_id'] }}"
                            class="bg-white dark:bg-base-100 rounded-xl shadow-md p-6 flex flex-col sm:flex-row items-center gap-6 transition-colors duration-200">
                            <div
                                class="w-full sm:w-32 h-32 bg-base-200 rounded-lg overflow-hidden flex-shrink-0 relative group">
                                <img alt="{{ $item['name'] }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    src="{{ $item['image'] }}" />
                                @if(!empty($item['flavor_names']))
                                    <span
                                        class="absolute top-2 left-2 bg-base-300 text-base-content text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                                        Personalizado
                                    </span>
                                @endif
                            </div>
                            <div class="flex-grow text-center sm:text-left">
                                <h3 class="text-xl font-bold mb-1 font-display text-brand-primary">
                                    {{ $item['name'] }}
                                </h3>
                                <p class="text-sm mb-3">{{ $item['description'] }}</p>
                                
                                {{-- Visual Flavors Display --}}
                                @if(!empty($item['flavors']))
                                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-4 mt-2">
                                        @php 
                                            $flavors = \App\Models\Flavor::whereIn('id', $item['flavors'])->get();
                                        @endphp
                                        @foreach($flavors as $flavor)
                                            <div class="flex items-center gap-2 bg-base-200/50 rounded-full pr-3 border border-base-300 shadow-xs transition-all hover:bg-base-200 group/flavor">
                                                <div class="w-6 h-6 rounded-full overflow-hidden ring-1 ring-base-300 flex-shrink-0" style="background-color: {{ $flavor->color ?? '#eee' }}">
                                                    @if($flavor->image)
                                                        <img src="{{ asset($flavor->image) }}" alt="{{ $flavor->name }}" class="w-full h-full object-cover">
                                                    @endif
                                                </div>
                                                <span class="text-[9px] font-bold uppercase text-base-content/70 whitespace-nowrap group-hover/flavor:text-brand-primary transition-colors">{{ $flavor->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="rounded-full bg-brand-primary text-white px-2 inline-block">
                                    <x-mary-icon label="Delivery" name="o-truck" />
                                </div>

                            </div>
                            <div class="flex flex-col items-center sm:items-end gap-3">
                                <span
                                    class="text-2xl font-bold">${{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</span>
                                <div class="flex items-center gap-3 bg-base-200/50 rounded-full px-2 py-1 shadow">
                                    <x-mary-button wire:click="decrement('{{ $item['unique_id'] }}')" icon="phosphor.minus"
                                        class="btn-circle btn-xs btn-ghost shadow" />
                                    <span class="font-bold w-4 text-center text-brand-primary">{{ $item['quantity'] }}</span>
                                    <x-mary-button wire:click="increment('{{ $item['unique_id'] }}')" icon="phosphor.plus"
                                        class="btn-circle btn-xs btn-ghost shadow" />
                                </div>
                                <x-mary-button wire:click="remove('{{ $item['unique_id'] }}')" icon="phosphor.trash"
                                    label="Eliminar" class="btn-ghost btn-xs text-error hover:bg-error/10" />
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-white dark:bg-base-100 rounded-xl shadow-md p-10 text-center">
                        <x-mary-icon name="phosphor.ice-cream" class="w-20 h-20 text-gray-300 mb-4 mx-auto" />
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Tu carrito está vacío</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">Parece que no has agregado ningún producto todavía.
                        </p>
                        <x-mary-button label="Elegir mi helado" icon="phosphor.ice-cream"
                            link="{{ route('shop.products') }}"
                            class="bg-brand-primary hover:bg-brand-secondary text-white" />
                    </div>
                @endif

                <div class="mt-6">
                    <x-mary-button label="Seguir Comprando" icon="phosphor.arrow-left"
                        link="{{ route('shop.products') }}" class="btn-ghost text-brand-primary font-bold" />
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:w-1/3">
                <x-order-summary :subtotal="$subtotal" :total="$total" :shipping="0">
                    <x-slot:actions>
                        @if(count($cartItems) > 0)
                            <x-mary-button wire:click="continueToCheckout" label="Continuar al Pago"
                                icon-right="phosphor.arrow-right" class="bg-brand-primary text-white w-full shadow-lg" />
                        @else
                            <x-mary-button disabled label="Continuar al Pago" icon-right="phosphor.arrow-right"
                                class="w-full" />
                        @endif
                    </x-slot:actions>
                </x-order-summary>
            </div>
        </div>
    </div>
</div>