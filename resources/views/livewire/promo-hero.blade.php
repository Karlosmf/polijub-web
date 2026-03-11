<section id="{{ $id }}" class="relative w-full min-h-[70vh] flex items-center justify-center overflow-hidden {{ $classes }}" 
    style="background-color: {{ $bg_color }}; background-image: url('{{ asset('images/nuevospng/petalos.webp') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    
    {{-- Overlay sutil para mejorar legibilidad si el fondo es muy cargado --}}
    <div class="absolute inset-0 bg-white/10 pointer-events-none"></div>

    {{-- Contenedor Central Relativo --}}
    <div class="relative w-full max-w-7xl mx-auto px-6 md:px-12 z-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            
            {{-- Columna Imagen Principal --}}
            <div class="relative flex items-center justify-center order-2 md:order-1">
                @if($image_path)
                    @php
                        $imgSrc = str_contains($image_path, '/') ? asset($image_path) : asset('storage/' . $image_path);
                        if(str_starts_with($image_path, 'hero/')) $imgSrc = asset('storage/' . $image_path);
                    @endphp
                    <img src="{{ $imgSrc }}" alt="{{ $title }}" class="max-w-full max-h-[450px] object-contain drop-shadow-2xl animate-float">
                @endif
            </div>

            {{-- Columna Texto --}}
            <div class="flex {{ $vertical_alignment }} {{ $content_alignment }} order-1 md:order-2">
                <div class="max-w-lg text-center md:text-left">
                    <h1 class="text-5xl md:text-8xl font-black mb-4 leading-none tracking-tighter" style="color: {{ $title_color }}">
                        {{ $title }}
                    </h1>

                    @if($show_subtitle && $subtitle)
                        <h2 class="text-2xl md:text-4xl font-bold mb-6 italic" style="color: {{ $subtitle_color }}">
                            {{ $subtitle }}
                        </h2>
                    @endif

                    @if($description)
                        <p class="text-lg md:text-xl text-gray-800 mb-8 font-medium leading-relaxed bg-white/40 backdrop-blur-sm p-4 rounded-lg inline-block">
                            {!! nl2br(e($description)) !!}
                        </p>
                    @endif

                    @if($show_button && $button_text)
                        <div>
                            <a href="{{ $button_url }}" class="inline-block px-12 py-4 bg-[#fe0196] text-white font-bold rounded-full hover:scale-110 transition-all duration-300 shadow-2xl uppercase tracking-widest">
                                {{ $button_text }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Overlays Dinámicos (Imágenes flotantes) --}}
    @foreach($overlays ?? [] as $overlay)
        @if($overlay['is_visible'] && !empty($overlay['image_path']))
            @php
                $overlaySrc = str_contains($overlay['image_path'], '/') ? asset($overlay['image_path']) : asset('storage/' . $overlay['image_path']);
                if(str_starts_with($overlay['image_path'], 'hero/')) $overlaySrc = asset('storage/' . $overlay['image_path']);
            @endphp
            <div class="absolute z-30 pointer-events-none"
                 style="left: {{ $overlay['position_x'] }}%; top: {{ $overlay['position_y'] }}%; transform: translate(-50%, -50%)">
                <img src="{{ $overlaySrc }}" class="max-w-[120px] md:max-w-[250px] h-auto drop-shadow-2xl animate-pulse">
            </div>
        @endif
    @endforeach

    <style>
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        .animate-float {
            animation: float 5s ease-in-out infinite;
        }
    </style>
</section>
