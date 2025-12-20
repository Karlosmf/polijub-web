<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.frontend')] class extends Component {
    // You could accept an order ID here later to show details
}; ?>

<div id="order-success-container" class="min-h-[70vh] flex items-center justify-center bg-base-200/30">
    <div class="text-center max-w-lg mx-auto p-8">
        {{-- Success Icon Animation --}}
        <div class="mb-8 relative inline-block">
            <div class="absolute inset-0 bg-brand-primary/20 rounded-full animate-ping"></div>
            <div class="relative bg-white p-4 rounded-full shadow-xl">
                <x-mary-icon name="phosphor.check-circle-fill" class="w-24 h-24 text-brand-primary" />
            </div>
        </div>

        <h1 class="text-4xl font-display font-bold text-brand-primary mb-4">
            ¡Pedido Recibido!
        </h1>

        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
            Muchas gracias por tu compra. Hemos recibido tu pedido correctamente y ya estamos preparando tus helados.
        </p>

        <div class="bg-white p-4 rounded-xl shadow border border-gray-100 mb-8 text-left">
            <h3 class="font-bold text-brand-primary mb-2 flex items-center">
                <x-mary-icon name="phosphor.info" class="w-8 h-8 text-brand-secondary mr-2" />
                ¿Qué sigue ahora?
            </h3>
            <p class="text-sm text-gray-500 mb-2">Te enviaremos un WhatsApp o correo confirmando cuando tu pedido esté
                en camino.</p>
        </div>

        <div class="flex gap-4 justify-center">
            <x-mary-button label="Volver al Inicio" link="/" icon="phosphor.ice-cream"
                class="btn-ghost text-accent-pink" />
            {{-- <x-mary-button label="Ver mis Pedidos" link="{{ route('shop.products') }}"
                icon-right="phosphor.arrow-right" class="btn-primary shadow-lg" /> --}}
        </div>
    </div>
    
    @push('scripts')
    <script>
        (function() {
            function launchConfetti() {
                // Check if we are still on the success page by looking for the unique container ID
                if (!document.getElementById('order-success-container')) return;
                
                if (typeof confetti === 'undefined') return;
                
                var duration = 3 * 1000;
                var animationEnd = Date.now() + duration;
                var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 9999 };

                function randomInRange(min, max) {
                    return Math.random() * (max - min) + min;
                }

                var interval = setInterval(function() {
                    // Safety check inside interval in case user navigated away quickly
                    if (!document.getElementById('order-success-container')) {
                        return clearInterval(interval);
                    }

                    var timeLeft = animationEnd - Date.now();

                    if (timeLeft <= 0) {
                        return clearInterval(interval);
                    }

                    var particleCount = 50 * (timeLeft / duration);
                    
                    confetti({ ...defaults, particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } });
                    confetti({ ...defaults, particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } });
                }, 250);
            }

            // Run on load
            launchConfetti();
            
            // Run on Livewire navigation
            document.addEventListener('livewire:navigated', launchConfetti);
        })();
    </script>
    @endpush
</div>