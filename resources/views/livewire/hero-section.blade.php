<section id="{{ $id }}" class="{{ $classes }}">
    {{-- Parte Superior: Título --}}
    @if($title)
        <div class="bg-white py-8 md:py-12 text-center">
            <h1 class="text-3xl md:text-5xl font-bold text-gray-800 uppercase tracking-widest">{{ $title }}</h1>
        </div>
    @endif

    {{-- Parte Inferior: Dos Columnas con imagen superpuesta --}}
    <div class="relative grid grid-cols-1 md:grid-cols-2 min-h-[50vh] overflow-hidden">
        {{-- Columna Izquierda: Imagen Principal (Torta/Producto) --}}
        <div class="bg-gray-100 flex items-center justify-center">
            @if($main_image)
                <img src="{{ asset($main_image) }}" alt="Hero Image" class="w-full h-full object-cover">
            @endif
        </div>

        {{-- Columna Derecha: Contenido Centrado --}}
        <div class="flex flex-col items-center justify-center p-8 md:p-16 text-center" style="background-color: {{ $right_bg_color }}">
            <div class="max-w-lg z-20">
                @if($right_title)
                    <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-[#fe0196] uppercase mb-4">{{ $right_title }}</h2>
                @endif
                
                @if($right_content)
                    <p class="text-base md:text-lg text-gray-700 leading-relaxed">
                        {!! nl2br(e($right_content)) !!}
                    </p>
                @endif

                @if($cta_text)
                    <a href="{{ $cta_link }}" class="mt-8 inline-block bg-[#fe0196] text-white font-bold py-4 px-12 rounded-[5px] hover:scale-105 transition-all duration-300 shadow-lg">
                        {{ $cta_text }}
                    </a>
                @endif
            </div>
        </div>

        {{-- Imagen Superpuesta (Overlay / GIF) --}}
        @if($overlay_image)
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10 w-1/2 md:w-1/4 pointer-events-none drop-shadow-2xl">
                 <img src="{{ asset($overlay_image) }}" alt="Overlay" class="w-full h-auto animate-pulse">
            </div>
        @endif
    </div>
</section>
