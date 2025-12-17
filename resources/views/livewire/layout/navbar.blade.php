<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public $cartCount = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    #[On('product-added-to-cart')]
    #[On('cart-updated')] // Assuming cart-review will dispatch this event too
    public function updateCartCount()
    {
        $cart = session()->get('cart', []);
        $this->cartCount = array_sum(array_column($cart, 'quantity'));
    }
}; ?>

<div>
    {{-- FRONTEND NAVBAR --}}
    <nav class="bg-brand-primary sticky top-0 z-50 shadow-lg">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex items-center justify-between h-20">

                {{-- Bloque Izquierdo: Logotipo --}}
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}"
                        class="flex items-center space-x-2 transform transition-transform duration-300 hover:scale-110 translate-y-10"
                        title="Ir al Inicio">
                        <img src="{{ asset('images/logo.webp') }}" alt="PoliJub Logo" class="h-40 w-auto"
                            onerror="this.src='https://via.placeholder.com/160'">
                    </a>
                </div>

                {{-- Bloque Central: Enlaces de Navegación (Escritorio) --}}
                <div class="flex items-center space-x-8 max-md:hidden">

                    <a href="{{ route('shop.products') }}"
                        class="text-white font-medium hover:text-brand-secondary transition-colors duration-200">PRODUCTOS</a>
                    <a href="{{ route('sabores.index') }}"
                        class="text-white font-medium hover:text-brand-secondary transition-colors duration-200">SABORES</a>
                    <a href="#"
                        class="text-white font-medium hover:text-brand-secondary transition-colors duration-200">NOSOTROS</a>
                    <a href="#"
                        class="text-white font-medium hover:text-brand-secondary transition-colors duration-200">CONTACTO
                    </a>

                </div>

                {{-- Bloque Derecho: Acciones (Escritorio) --}}
                <div class="flex items-center space-x-6 max-md:hidden">
                    @auth
                        <x-dropdown right>
                            <x-slot:trigger>
                                <button
                                    class="flex items-center space-x-2 text-white font-medium hover:text-brand-secondary transition-colors duration-200">
                                    <x-icon name="o-user" class="h-6 w-6" />
                                    <span>{{ Auth::user()->name }}</span>
                                    <x-icon name="o-chevron-down" class="h-4 w-4" />
                                </button>
                            </x-slot:trigger>
                            <x-menu-item title="Mi Perfil" link="{{ route('admin.profile') }}" />
                            <x-menu-item title="Cerrar Sesión" link="/logout" class="text-error" />
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}"
                            class="flex items-center space-x-2 text-white font-medium hover:text-brand-secondary transition-colors duration-200">
                            <x-icon name="o-user" class="h-6 w-6" />
                            <span>Entrar</span>
                        </a>
                    @endauth
                </div>

                {{-- Botón de Menú Móvil --}}
                <div class="hidden max-md:flex items-center">
                    <label for="mobile-drawer"
                        class="p-2 rounded-md hover:bg-white/20 focus:outline-none transition-colors cursor-pointer">
                        <x-icon name="o-bars-3" class="h-6 w-6" />
                    </label>
                </div>
            </div>
        </div>
    </nav>

    {{-- MOBILE MENU DRAWER --}}
    <x-drawer id="mobile-drawer" class="hidden max-md:block bg-brand-primary" right with-close-button>
        <div class="flex flex-col items-center space-y-4 py-8 px-4 text-white h-full overflow-y-auto">

            {{-- Acordeón PRODUCTOS --}}
            <a href="{{ route('shop.products') }}"
                class="text-white font-medium hover:text-brand-secondary transition-colors duration-200">PRODUCTOS</a>
            <a href="{{ route('sabores.index') }}"
                class="text-white font-medium hover:text-brand-secondary transition-colors duration-200">SABORES</a>
            <a href="#"
                class="text-white font-medium hover:text-brand-secondary transition-colors duration-200">NOSOTROS</a>
            <a href="#"
                class="text-white font-medium hover:text-brand-secondary transition-colors duration-200">CONTACTO</a>

            <div class="border-t border-white/20 w-3/4 pt-6 flex flex-col items-center space-y-6">
                @auth
                    <a href="{{ route('admin.profile') }}" class="text-lg font-medium hover:text-brand-secondary">Mi
                        Perfil</a>
                    <a href="/logout" class="text-lg font-medium hover:text-brand-secondary">Cerrar Sesión</a>
                @else
                    <a href="{{ route('login') }}" class="text-lg font-medium hover:text-brand-secondary">Entrar</a>
                    <a href="{{ route('register') }}" class="text-lg font-medium hover:text-brand-secondary">Registrarse</a>
                @endauth

            </div>
        </div>
    </x-drawer>
</div>