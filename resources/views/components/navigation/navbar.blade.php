<nav x-data="{ open: false }" class="bg-brand-primary text-white sticky top-0 z-50 shadow-lg">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex items-center justify-between h-20">

            <!-- Bloque Izquierdo: Logotipo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="flex items-center space-x-2 transform transition-transform duration-300 hover:scale-110 translate-y-10" title="Ir al Inicio">
                    <img src="{{ asset('images/logo.webp') }}" alt="PoliJub Logo" class="h-40 w-auto">
                </a>
            </div>

            <!-- Bloque Central: Enlaces de Navegación (Escritorio) -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8">
                
                <div x-data="{ dropdownOpen: false }" @mouseleave="setTimeout(() => { dropdownOpen = false }, 200)" class="relative">
                    <button @mouseover="dropdownOpen = true" class="flex items-center space-x-1 text-base font-medium hover:text-brand-secondary transition-colors duration-200">
                        <span>PRODUCTOS</span>
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                    <div x-show="dropdownOpen" class="origin-top-right absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 text-gray-700" x-transition>
                        <div class="py-1">
                            <a href="{{ route('sabores.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">SABORES</a>
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">POSTRES</a>
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">PALETAS</a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('shop.products') }}" class="text-base font-medium hover:text-brand-secondary transition-colors duration-200">TIENDA</a>
                <a href="#" class="text-base font-medium hover:text-brand-secondary transition-colors duration-200">DELIVERY</a>
                <a href="#" class="text-base font-medium hover:text-brand-secondary transition-colors duration-200">PRECIOS</a>

                <!-- Dropdown de NOSOTROS -->
                <div x-data="{ dropdownOpen: false }" @mouseleave="setTimeout(() => { dropdownOpen = false }, 200)" class="relative">
                    <button @mouseover="dropdownOpen = true" class="flex items-center space-x-1 text-base font-medium hover:text-brand-secondary transition-colors duration-200">
                        <span>NOSOTROS</span>
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                    <div x-show="dropdownOpen" class="origin-top-right absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 text-gray-700" x-transition>
                        <div class="py-1">
                            <a href="{{ route('about.index') }}#suscripciones" class="block px-4 py-2 text-sm hover:bg-gray-100">SUSCRIPCIONES</a>
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">PREGUNTAS</a>
                            <a href="{{ route('about.index') }}#contacto" class="block px-4 py-2 text-sm hover:bg-gray-100">CONTACTO</a>
                            <a href="{{ route('about.index') }}#cv" class="block px-4 py-2 text-sm hover:bg-gray-100">ENVIANOS TU CV</a>
                            <a href="{{ route('about.index') }}#franquicias" class="block px-4 py-2 text-sm hover:bg-gray-100">FRANQUICIAS</a>
                        </div>
                    </div>
                </div>

                <a href="#" class="text-base font-medium hover:text-brand-secondary transition-colors duration-200">MÁS</a>
            </div>

            <!-- Bloque Derecho: Acciones (Escritorio) -->
            <div class="hidden lg:flex lg:items-center lg:space-x-6">
                @auth
                    <div x-data="{ dropdownOpen: false }" @mouseleave="setTimeout(() => { dropdownOpen = false }, 200)" class="relative">
                        <button @mouseover="dropdownOpen = true" class="flex items-center space-x-2 text-base font-medium hover:text-brand-secondary transition-colors duration-200">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 text-gray-700" x-transition>
                            <div class="py-1">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Mi Perfil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm hover:bg-gray-100">Cerrar Sesión</a>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="flex items-center space-x-2 text-base font-medium hover:text-brand-secondary transition-colors duration-200">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <span>Entrar</span>
                    </a>
                @endauth
                <a href="#" class="relative hover:text-brand-secondary transition-colors duration-200" title="Carrito de Compras (Próximamente)">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </a>
            </div>

            <!-- Botón de Menú Móvil -->
            <div class="lg:hidden flex items-center">
                <button @click="open = !open" class="p-2 rounded-md hover:bg-white/20 focus:outline-none transition-colors">
                    <svg :class="{'hidden': open}" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    <svg :class="{'hidden': !open}" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Panel de Menú Móvil -->
    <div :class="{'block': open, 'hidden': !open}" class="lg:hidden absolute top-20 left-0 w-full bg-brand-primary/95 backdrop-blur-sm shadow-xl">
        <div class="flex flex-col items-center space-y-4 py-8 px-4">
            
            <!-- Acordeón de PRODUCTOS para Móvil -->
            <div x-data="{ accordionOpen: false }" class="w-full text-center">
                <button @click="accordionOpen = !accordionOpen" class="text-lg font-medium hover:text-brand-secondary w-full flex items-center justify-center">
                    <span>PRODUCTOS</span>
                    <svg class="h-5 w-5 ml-1 transform transition-transform duration-200" :class="{'rotate-180': accordionOpen}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
                <div x-show="accordionOpen" class="mt-2 space-y-3 bg-white/10 rounded-lg p-4">
                    <a href="{{ route('sabores.index') }}" class="block text-base hover:text-white">SABORES</a>
                    <a href="#" class="block text-base hover:text-white">POSTRES</a>
                    <a href="#" class="block text-base hover:text-white">PALETAS</a>
                </div>
            </div>

            <a href="{{ route('shop.products') }}" class="text-lg font-medium hover:text-brand-secondary">TIENDA</a>
            <a href="#" class="text-lg font-medium hover:text-brand-secondary">DELIVERY</a>
            <a href="#" class="text-lg font-medium hover:text-brand-secondary">PRECIOS</a>

            <!-- Acordeón de NOSOTROS para Móvil -->
            <div x-data="{ accordionOpen: false }" class="w-full text-center">
                <button @click="accordionOpen = !accordionOpen" class="text-lg font-medium hover:text-brand-secondary w-full flex items-center justify-center">
                    <span>NOSOTROS</span>
                    <svg class="h-5 w-5 ml-1 transform transition-transform duration-200" :class="{'rotate-180': accordionOpen}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
                <div x-show="accordionOpen" class="mt-2 space-y-3 bg-white/10 rounded-lg p-4">
                    <a href="{{ route('about.index') }}#suscripciones" class="block text-base hover:text-white">SUSCRIPCIONES</a>
                    <a href="#" class="block text-base hover:text-white">PREGUNTAS</a>
                    <a href="{{ route('about.index') }}#contacto" class="block text-base hover:text-white">CONTACTO</a>
                    <a href="{{ route('about.index') }}#cv" class="block text-base hover:text-white">ENVIANOS TU CV</a>
                    <a href="{{ route('about.index') }}#franquicias" class="block text-base hover:text-white">FRANQUICIAS</a>
                </div>
            </div>

            <a href="#" class="text-lg font-medium hover:text-brand-secondary">MÁS</a>

            <div class="border-t border-white/20 w-3/4 pt-6 flex flex-col items-center space-y-6">
                @auth
                    <a href="{{ route('profile') }}" class="text-lg font-medium hover:text-brand-secondary">Mi Perfil</a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full text-center">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-lg font-medium hover:text-brand-secondary">Cerrar Sesión</a>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-lg font-medium hover:text-brand-secondary">Entrar</a>
                    <a href="{{ route('register') }}" class="text-lg font-medium hover:text-brand-secondary">Registrarse</a>
                @endauth
                <a href="#" class="relative hover:text-brand-secondary pt-4" title="Carrito de Compras (Próximamente)">
                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </a>
            </div>
        </div>
    </div>
</nav>
