<section id="{{ $id }}" class="relative min-h-[80vh] flex items-center {{ $classes }}"
    style="background-image: url('{{ asset($bg_image) }}'); background-size: cover; background-position: center;">

    {{-- Contenido de Texto --}}
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="bg-white shadow-2xl rounded-lg p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-center">
                <div class="text-left">
                    <h2 class="text-6xl lg:text-7xl font-thin tracking-wider text-[#DCD7CA]">{{ $title }}</h2>
                    <p class="mt-4 font-light text-gray-700 leading-relaxed">
                        {!! nl2br(e($content)) !!}
                    </p>
                </div>
                <div class="flex justify-start mt-8 md:mt-0">
                    <a href="{{ $button_url }}"
                        class="inline-block bg-brand-primary text-white uppercase font-bold tracking-widest py-4 px-10 rounded-md shadow-lg hover:bg-opacity-90 transition-transform hover:scale-105">
                        {{ $button_text }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Imagen Superpuesta --}}
    @if($overlay_image)
        <img src="{{ asset($overlay_image) }}" alt="Overlay"
            class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full z-0">
    @endif
</section>
