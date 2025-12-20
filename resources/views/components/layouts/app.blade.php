<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
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

<body class="min-h-screen font-sans antialiased">
    {{-- NAVBAR mobile only --}}
    <x-mary-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
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
            <x-app-brand class="p-4 pt-3" />

            {{-- MENU --}}
            <x-mary-menu activate-by-route>

                {{-- User Profile --}}
                @if($user = auth()->user())
                    <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                        class="-mx-2 !-mt-2 rounded bg-base-300">
                        <x-slot:actions>
                            <x-mary-button icon="o-power" class="btn-circle btn-ghost btn-xs hover:text-error"
                                tooltip-left="SALIR" no-wire-navigate link="/logout" />
                        </x-slot:actions>
                    </x-mary-list-item>
                @else
                    <x-mary-menu-item title="Iniciar Sesión" icon="o-user" link="{{ route('login') }}" />
                @endif

                <x-mary-menu-sub title="PRODUCTOS" icon="o-cube">
                    <x-mary-menu-item title="SABORES" link="{{ route('flavors.index') }}" />
                    <x-mary-menu-item title="POSTRES" link="#" />
                    <x-mary-menu-item title="PALETAS" link="#" />
                </x-mary-menu-sub>

                <x-mary-menu-item title="TIENDA" icon="o-shopping-bag" link="{{ route('shop.products') }}" />
                <x-mary-menu-item title="DELIVERY" icon="o-truck" link="#" />
                <x-mary-menu-item title="PRECIOS" icon="o-currency-dollar" link="#" />

                <x-mary-menu-sub title="NOSOTROS" icon="o-users">
                    <x-mary-menu-item title="SOBRE NOSOTROS" link="{{ route('about.index') }}" />
                    <x-mary-menu-item title="PREGUNTAS" link="#" />
                    <x-mary-menu-item title="CONTACTO" link="{{ route('contact.index') }}#contacto" />
                    <x-mary-menu-item title="ENVIANOS TU CV" link="{{ route('contact.index') }}#cv" />
                    <x-mary-menu-item title="FRANQUICIAS" link="{{ route('contact.index') }}#franquicias" />
                </x-mary-menu-sub>

                <x-mary-menu-item title="MÁS" icon="o-ellipsis-horizontal" link="#" />

                {{-- Admin/Authenticated Options (Optional - kept generic for now) --}}
                @auth
                    <x-mary-menu-item title="Mi Perfil" icon="o-user" link="{{ route('admin.profile') }}" />
                @endauth

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