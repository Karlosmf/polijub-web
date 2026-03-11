<div id="{{ $id }}" class="py-20 sm:py-24 relative overflow-hidden {{ $classes }}"
    style="background: linear-gradient(to bottom, #EBEBEB 0%, #f0f0f0 50%, #EBEBEB 100%);">
    
    <!-- Background Image -->
    @if($bg_image)
        <div class="absolute inset-0 z-0 opacity-90">
            <img src="{{ asset($bg_image) }}" alt="Background"
                class="absolute top-1/2 left-1/2 w-1/2 max-w-lg -translate-x-1/4 -translate-y-1/2 -rotate-12 transform">
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <!-- Columna 1: 100% NATURAL -->
            <div class="text-center md:text-left">
                <h2 class="text-5xl md:text-6xl font-bold uppercase text-emerald-500">
                    {{ $title }}
                </h2>
                <p class="mt-4 text-gray-600 text-lg">
                    {!! nl2br(e($content)) !!}
                </p>
                <div class="mt-8">
                    <x-mary-button label="Descubrir más"
                        class="btn-primary bg-emerald-500 hover:bg-emerald-600 border-none text-white" link="#" />
                </div>
            </div>

            <!-- Columna 2: Logo y Enlace -->
            <div class="w-full flex flex-col items-center lg:items-end text-center lg:text-right">
                @if($logo_image)
                    <img src="{{ asset($logo_image) }}" alt="Logo"
                        class="w-1/3 h-auto mx-auto lg:mx-0 mb-4">
                @endif
                <div class="mt-8">
                    <a href="{{ $button_url }}"
                        class="inline-block bg-accent-blue hover:opacity-90 text-white uppercase font-semibold py-3 px-8 rounded-full transition-opacity duration-300">
                        {{ $button_text }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
