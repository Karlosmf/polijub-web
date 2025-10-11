<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>{{ $title ?? 'Polijub Heladería' }}</title>

<!-- Importación de Tailwind CSS -->
@vite('resources/css/app.css')

<!-- Directivas de estilos de Livewire -->
@livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased">
{{--
Este slot es el contenedor principal donde Livewire inyectará
el contenido de la página o componente que se esté renderizando.
--}}
{{ $slot }}

<!-- Directivas de scripts de Livewire -->
@livewireScripts

<!-- Importación de JavaScript de la aplicación -->
@vite('resources/js/app.js')
</body>
</html>