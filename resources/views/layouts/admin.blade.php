<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' : '' }}Admin Polijub</title>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago("{{ config('mercadopago.public_key') }}", {
            locale: 'es-AR'
        });
    </script>
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" defer></script>
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
    {{-- NAVBAR mobile only --}}
    <x-mary-nav sticky class="lg:hidden">
        <x-slot:brand>
             <div class="ml-5 pt-5 text-2xl font-bold text-brand-primary">Polijub</div>
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-mary-nav>

    {{-- MAIN --}}
    <x-mary-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <div class="p-6 pt-8 flex items-center gap-3">
                <div class="avatar">
                    <div class="w-11 rounded-full">
                        <img src="{{ asset('images/logo.webp') }}" alt="Polijub Logo" onerror="this.src='https://via.placeholder.com/40'" />
                    </div>
                </div>
                <div class="font-bold text-2xl text-brand-primary">
                    Polijub
                    <span class="block text-xs font-normal text-gray-400 -mt-1">Admin Panel</span>
                </div>
            </div>

            {{-- MENU --}}
            <x-mary-menu activate-by-route>

                {{-- User --}}
                @if($user = auth()->user())
                    <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="mb-5 -mx-2 rounded-lg bg-base-200/50 border border-base-200">
                         <x-slot:actions>
                            <x-mary-button icon="o-power" class="btn-circle btn-ghost btn-xs hover:text-error"
                                tooltip-left="SALIR" no-wire-navigate link="/logout" />
                        </x-slot:actions>
                    </x-mary-list-item>
                @endif

                <x-mary-menu-sub title="Gestión" icon="o-squares-2x2">
                    <x-mary-menu-item title="Dashboard" icon="o-home" link="{{ route('admin.dashboard') }}" />
                    <x-mary-menu-item title="Carrusel" icon="o-photo" link="{{ route('admin.carousel') }}" />
                    <x-mary-menu-item title="Pedidos" icon="o-shopping-bag" link="{{ route('admin.orders') }}" />
                </x-mary-menu-sub>

                <x-mary-menu-sub title="Catálogo" icon="o-cube" open>
                    <x-mary-menu-item title="Productos" icon="o-cube" link="{{ route('admin.products') }}" />
                    <x-mary-menu-item title="Sabores" icon="o-beaker" link="{{ route('admin.flavors') }}" />
                    <x-mary-menu-item title="Etiquetas" icon="o-tag" link="{{ route('admin.tags') }}" />
                </x-mary-menu-sub>

                <x-mary-menu-separator />

                <x-mary-menu-item title="Ver Sitio Web" icon="o-globe-alt" link="/" external />
                
                <x-mary-menu-separator />
                
                {{-- Theme Toggle --}}
                <div class="px-4 mt-2">
                    <x-mary-theme-toggle class="btn btn-circle btn-ghost" />
                </div>

            </x-mary-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>

    {{-- TOAST area --}}
    <x-mary-toast />
    @livewireScripts
    @stack('scripts')
</body>
</html>