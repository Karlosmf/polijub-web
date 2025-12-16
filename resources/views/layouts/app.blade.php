<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - ' : '' }}Polijub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-gray-100">

    {{-- NAVBAR --}}
    <nav class="bg-brand-primary text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex items-center justify-between h-20">

                {{-- Bloque Izquierdo: Logotipo --}}
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2 transform transition-transform duration-300 hover:scale-110 translate-y-10" title="Ir al Inicio">
                        <img src="{{ asset('images/logo.webp') }}" alt="PoliJub Logo" class="h-40 w-auto" onerror="this.src='https://via.placeholder.com/160'">
                    </a>
                </div>

                {{-- Bloque Central: Enlaces de Navegación (Escritorio) --}}
                <div class="hidden lg:flex lg:items-center lg:space-x-8">
                    
                    {{-- Dropdown PRODUCTOS --}}
                    <x-dropdown>
                        <x-slot:trigger>
                            <button class="flex items-center space-x-1 text-base font-medium hover:text-brand-secondary transition-colors duration-200">
                                <span>PRODUCTOS</span>
                                <x-icon name="o-chevron-down" class="h-4 w-4" />
                            </button>
                        </x-slot:trigger>
                        <x-menu-item title="SABORES" link="{{ route('sabores.index') }}" />
                        <x-menu-item title="POSTRES" link="#" />
                        <x-menu-item title="PALETAS" link="#" />
                    </x-dropdown>

                    <a href="{{ route('shop.products') }}" class="text-base font-medium hover:text-brand-secondary transition-colors duration-200">TIENDA</a>
                    <a href="#" class="text-base font-medium hover:text-brand-secondary transition-colors duration-200">DELIVERY</a>
                    <a href="#" class="text-base font-medium hover:text-brand-secondary transition-colors duration-200">PRECIOS</a>

                    {{-- Dropdown NOSOTROS --}}
                    <x-dropdown>
                        <x-slot:trigger>
                            <button class="flex items-center space-x-1 text-base font-medium hover:text-brand-secondary transition-colors duration-200">
                                <span>NOSOTROS</span>
                                <x-icon name="o-chevron-down" class="h-4 w-4" />
                            </button>
                        </x-slot:trigger>
                        <x-menu-item title="SUSCRIPCIONES" link="{{ route('about.index') }}#suscripciones" />
                        <x-menu-item title="PREGUNTAS" link="#" />
                        <x-menu-item title="CONTACTO" link="{{ route('about.index') }}#contacto" />
                        <x-menu-item title="ENVIANOS TU CV" link="{{ route('about.index') }}#cv" />
                        <x-menu-item title="FRANQUICIAS" link="{{ route('about.index') }}#franquicias" />
                    </x-dropdown>

                    <a href="#" class="text-base font-medium hover:text-brand-secondary transition-colors duration-200">MÁS</a>
                </div>

                {{-- Bloque Derecho: Acciones (Escritorio) --}}
                <div class="hidden lg:flex lg:items-center lg:space-x-6">
                    @auth
                        <x-dropdown right>
                            <x-slot:trigger>
                                <button class="flex items-center space-x-2 text-base font-medium hover:text-brand-secondary transition-colors duration-200">
                                    <x-icon name="o-user" class="h-6 w-6" />
                                    <span>{{ Auth::user()->name }}</span>
                                    <x-icon name="o-chevron-down" class="h-4 w-4" />
                                </button>
                            </x-slot:trigger>
                            <x-menu-item title="Mi Perfil" link="{{ route('admin.profile') }}" />
                            <x-menu-item title="Cerrar Sesión" link="/logout" class="text-error" />
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center space-x-2 text-base font-medium hover:text-brand-secondary transition-colors duration-200">
                            <x-icon name="o-user" class="h-6 w-6" />
                            <span>Entrar</span>
                        </a>
                    @endauth

                    <a href="#" class="relative hover:text-brand-secondary transition-colors duration-200" title="Carrito de Compras">
                        <x-icon name="o-shopping-bag" class="h-6 w-6" />
                    </a>
                </div>

                {{-- Botón de Menú Móvil --}}
                <div class="lg:hidden flex items-center">
                    <label for="mobile-drawer" class="p-2 rounded-md hover:bg-white/20 focus:outline-none transition-colors cursor-pointer">
                        <x-icon name="o-bars-3" class="h-6 w-6" />
                    </label>
                </div>
            </div>
        </div>
    </nav>

    {{-- MOBILE MENU DRAWER --}}
    <x-drawer id="mobile-drawer" class="lg:hidden" right with-close-button>
        <div class="flex flex-col items-center space-y-4 py-8 px-4 bg-brand-primary text-white h-full overflow-y-auto">
            
            {{-- Acordeón PRODUCTOS --}}
            <x-collapse class="w-full text-center group">
                <x-slot:heading>
                    <span class="text-lg font-medium group-hover:text-brand-secondary">PRODUCTOS</span>
                </x-slot:heading>
                <x-slot:content class="bg-white/10 rounded-lg text-white">
                    <x-menu-item title="SABORES" link="{{ route('sabores.index') }}" class="text-white hover:text-brand-secondary" />
                    <x-menu-item title="POSTRES" link="#" class="text-white hover:text-brand-secondary" />
                    <x-menu-item title="PALETAS" link="#" class="text-white hover:text-brand-secondary" />
                </x-slot:content>
            </x-collapse>

            <a href="{{ route('shop.products') }}" class="text-lg font-medium hover:text-brand-secondary">TIENDA</a>
            <a href="#" class="text-lg font-medium hover:text-brand-secondary">DELIVERY</a>
            <a href="#" class="text-lg font-medium hover:text-brand-secondary">PRECIOS</a>

            {{-- Acordeón NOSOTROS --}}
            <x-collapse class="w-full text-center group">
                <x-slot:heading>
                    <span class="text-lg font-medium group-hover:text-brand-secondary">NOSOTROS</span>
                </x-slot:heading>
                <x-slot:content class="bg-white/10 rounded-lg text-white">
                    <x-menu-item title="SUSCRIPCIONES" link="{{ route('about.index') }}#suscripciones" class="text-white hover:text-brand-secondary" />
                    <x-menu-item title="PREGUNTAS" link="#" class="text-white hover:text-brand-secondary" />
                    <x-menu-item title="CONTACTO" link="{{ route('about.index') }}#contacto" class="text-white hover:text-brand-secondary" />
                    <x-menu-item title="CV" link="{{ route('about.index') }}#cv" class="text-white hover:text-brand-secondary" />
                    <x-menu-item title="FRANQUICIAS" link="{{ route('about.index') }}#franquicias" class="text-white hover:text-brand-secondary" />
                </x-slot:content>
            </x-collapse>

            <a href="#" class="text-lg font-medium hover:text-brand-secondary">MÁS</a>

            <div class="border-t border-white/20 w-3/4 pt-6 flex flex-col items-center space-y-6">
                @auth
                    <a href="{{ route('admin.profile') }}" class="text-lg font-medium hover:text-brand-secondary">Mi Perfil</a>
                    <a href="/logout" class="text-lg font-medium hover:text-brand-secondary">Cerrar Sesión</a>
                @else
                    <a href="{{ route('login') }}" class="text-lg font-medium hover:text-brand-secondary">Entrar</a>
                    <a href="{{ route('register') }}" class="text-lg font-medium hover:text-brand-secondary">Registrarse</a>
                @endauth
                
                <a href="#" class="relative hover:text-brand-secondary pt-4">
                    <x-icon name="o-shopping-bag" class="h-8 w-8" />
                </a>
            </div>
        </div>
    </x-drawer>

    {{-- MAIN CONTENT --}}
    <main>
        {{ $slot }}
    </main>

    <x-toast />
</body>
</html>