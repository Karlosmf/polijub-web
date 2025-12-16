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
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <x-app-brand class="p-4 pt-3" />

            {{-- MENU --}}
            <x-menu activate-by-route>

                {{-- User Profile --}}
                @if($user = auth()->user())
                    <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                        class="-mx-2 !-mt-2 rounded bg-base-300">
                        <x-slot:actions>
                            <x-button icon="o-power" class="btn-circle btn-ghost btn-xs hover:text-error"
                                tooltip-left="SALIR" no-wire-navigate link="/logout" />
                        </x-slot:actions>
                    </x-list-item>
                @else
                    <x-menu-item title="Iniciar Sesión" icon="o-user" link="{{ route('login') }}" />
                @endif

                <x-menu-sub title="PRODUCTOS" icon="o-cube">
                    <x-menu-item title="SABORES" link="{{ route('sabores.index') }}" />
                    <x-menu-item title="POSTRES" link="#" />
                    <x-menu-item title="PALETAS" link="#" />
                </x-menu-sub>

                <x-menu-item title="TIENDA" icon="o-shopping-bag" link="{{ route('shop.products') }}" />
                <x-menu-item title="DELIVERY" icon="o-truck" link="#" />
                <x-menu-item title="PRECIOS" icon="o-currency-dollar" link="#" />

                <x-menu-sub title="NOSOTROS" icon="o-users">
                    <x-menu-item title="SUSCRIPCIONES" link="{{ route('about.index') }}#suscripciones" />
                    <x-menu-item title="PREGUNTAS" link="#" />
                    <x-menu-item title="CONTACTO" link="{{ route('about.index') }}#contacto" />
                    <x-menu-item title="ENVIANOS TU CV" link="{{ route('about.index') }}#cv" />
                    <x-menu-item title="FRANQUICIAS" link="{{ route('about.index') }}#franquicias" />
                </x-menu-sub>

                <x-menu-item title="MÁS" icon="o-ellipsis-horizontal" link="#" />

                {{-- Admin/Authenticated Options (Optional - kept generic for now) --}}
                @auth
                    <x-menu-item title="Mi Perfil" icon="o-user" link="{{ route('admin.profile') }}" />
                @endauth

            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{-- TOAST area --}}
    <x-toast />
    @livewireScripts
    @stack('scripts')
</body>

</html>