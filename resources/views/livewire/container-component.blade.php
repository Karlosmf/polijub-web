<div id="{{ $id }}" class="{{ $display }} {{ $classes }}">
    @if(count($children) > 0)
        {{-- Llamamos recursivamente al renderizador pasando los hijos --}}
        @livewire('section-renderer', ['sections' => $children, 'page' => null], key('sub-'.$id))
    @else
        <div class="border-2 border-dashed border-gray-300 p-8 text-center text-gray-400 rounded-lg">
            Contenedor vacío - Añade componentes desde el administrador
        </div>
    @endif
</div>
