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

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
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

                {{-- SETEO User --}}
                @if($user = auth()->user())
                    <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                        class="-mx-2 !-mt-2 rounded bg-black/20">
                        <x-slot:actions>
                            <x-mary-button icon="o-power" class="btn-circle btn-ghost btn-xs hover:text-error"
                                tooltip-left="SALIR" no-wire-navigate link="/logout" />
                        </x-slot:actions>
                    </x-mary-list-item>
                    <livewire:bookmarks />
                @endif

                <x-mary-menu-item title="Dashboard" icon="o-sparkles" link="/dashboard" />
                <x-mary-menu-item title="Comunicación" icon="o-chat-bubble-left-right" link="/chat" no-wire-navigate />
                @if($user->hasAnyRole(['admin', 'principal', 'administrative', 'teacher']))
                    <x-mary-menu-item title="Calendario" icon="o-calendar" link="/calendar" />
                @endif
                @if($user->hasAnyRole(['admin', 'principal', 'administrative']))
                    <x-mary-menu-item title="Usuarios" icon="o-users" link="/users" />
                    <x-mary-menu-sub title="{{ config('app.name') }}" icon="o-building-library">
                        <x-mary-menu-item title="Carreras" icon="o-academic-cap" link="/careers" />
                        <x-mary-menu-item title="Materias" icon="o-rectangle-stack" link="/subjects" />
                        <x-mary-menu-item title="Materias-Usuarios" icon="o-arrow-path-rounded-square" link="/enrollments" />
                    </x-mary-menu-sub>
                @endif
                @if($user->hasAnyRole(['admin', 'principal', 'administrative', 'teacher']))
                    <x-mary-menu-sub title="Clases" icon="o-document-duplicate">
                        <x-mary-menu-item title="Libros de Temas" icon="o-book-open" link="/class-sessions" />
                        <x-mary-menu-item title="Estudiantes" icon="o-user-group" link="/class-sessions/students" />
                    </x-mary-menu-sub>
                @endif
                @if($user->hasAnyRole(['admin', 'principal', 'administrative']))
                    <x-mary-menu-sub title="Admin Inscripciones" icon="o-clipboard-document-check">
                        <x-mary-menu-item title="Inscripciones" icon="o-clipboard-document-check" link="/inscriptions" />
                        <x-mary-menu-item title="Inscriptos" icon="o-clipboard-document-list" link="/inscriptions/list" />
                        <x-mary-menu-item title="Inscriciones PDFs" icon="o-clipboard-document" link="/inscriptions/pdfs" />
                    </x-mary-menu-sub>
                    <x-mary-menu-sub title="Pagos" icon="o-currency-dollar">
                        <x-mary-menu-item title="Registrar Pagos" icon="o-users" link="/user-payments-index" />
                        <x-mary-menu-item title="Planes de Pago" icon="o-calendar-days" link="/pay-plans" />
                        <x-mary-menu-item title="Reporte de Pagos" icon="o-chart-bar" link="/report-payments" />
                    </x-mary-menu-sub>
                    <x-mary-menu-sub title="Configuración" icon="o-cog-6-tooth">
                        <x-mary-menu-item title="Importar Usuarios" icon="o-user-plus" link="/users/import" />
                        <x-mary-menu-item title="Parámetros" icon="o-adjustments-horizontal" link="/configs" />
                        <x-mary-menu-item title="Caché" icon="o-wrench-screwdriver" link="/clear" />
                    </x-mary-menu-sub>
                @endif
                @if($user->hasAnyRole(['student']))
                    <x-mary-menu-item title="Calendario" icon="o-calendar" link="/calendar" />
                    <x-mary-menu-item title="Matricularse" icon="o-academic-cap" link="/enrollments" />
                    <x-mary-menu-item title="Inscripciones" icon="o-clipboard-document-check" link="/inscriptions" />
                    <x-mary-menu-item title="Mis Pagos" icon="o-currency-dollar" link="{{ route('my-payment-plan') }}" />
                @endif
                @if($user->hasAnyRole(['teacher']))
                    <x-mary-menu-item title="Inscriptos" icon="o-clipboard-document-list" link="/inscriptions/list" />
                @endif

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