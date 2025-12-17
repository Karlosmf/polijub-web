<div class="fixed top-24 right-4 z-[100]">
    <a href="{{ route('checkout.cart') }}" class="relative inline-flex items-center justify-center p-3 rounded-full bg-brand-primary text-white shadow-lg hover:bg-brand-secondary transition-all duration-300 transform hover:scale-105"
        title="Ver Carrito" wire:navigate>
        <x-phosphor-ice-cream class="h-8 w-8" />
        @if ($cartCount > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center border-2 border-white shadow-sm">
                {{ $cartCount }}
            </span>
        @endif
    </a>
</div>