<div>
    @foreach($sections as $section)
        @php
            $componentName = $section['component'];
            $props = $section;
            unset($props['component']);
            // Generar una clave única basada en el ID y el contenido
            $key = ($props['id'] ?? $loop->index) . '_' . md5(json_encode($props));
        @endphp

        @livewire($componentName, $props, key($key))
    @endforeach
</div>
