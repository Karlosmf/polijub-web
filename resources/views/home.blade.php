<x-app-layout>
    {{-- Renderizador dinámico para la página principal --}}
    @livewire('section-renderer', ['page' => 'landing'])

    {{-- 
        Si deseas mantener secciones fijas que no cambian, 
        puedes dejarlas aquí debajo o arriba del renderer.
    --}}
</x-app-layout>
