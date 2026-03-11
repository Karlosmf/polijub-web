<div id="wrapper-{{ $id }}" class="{{ $classes }}" style="height: {{ $height }}">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <div class="swiper mySwiper-{{ $id }} w-full h-full">
        <div class="swiper-wrapper">
            @foreach($slides as $slide)
                <div class="swiper-slide relative">
                    <img src="{{ asset($slide['image']) }}" alt="{{ $slide['title'] ?? '' }}" class="w-full h-full object-cover">
                    
                    @if(!empty($slide['title']))
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center text-center p-6">
                            <div class="max-w-2xl">
                                <h2 class="text-4xl md:text-6xl font-black text-white drop-shadow-lg uppercase tracking-tighter mb-4 animate__animated animate__fadeInUp">
                                    {{ $slide['title'] }}
                                </h2>
                                @if(!empty($slide['link']))
                                    <a href="{{ $slide['link'] }}" class="inline-block px-8 py-3 bg-brand-primary text-white font-bold rounded-md shadow-xl hover:scale-105 transition-transform">
                                        Ver más
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Controles --}}
        @if($show_dots)
            <div class="swiper-pagination"></div>
        @endif
        
        @if($show_arrows)
            <div class="swiper-button-next !text-white drop-shadow-md"></div>
            <div class="swiper-button-prev !text-white drop-shadow-md"></div>
        @endif
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            new Swiper(".mySwiper-{{ $id }}", {
                loop: true,
                effect: "{{ $effect }}",
                speed: 800,
                autoplay: {
                    delay: {{ $delay }},
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        });

        // Reinicializar después de actualizaciones de Livewire (para el modo edición)
        document.addEventListener('sectionUpdated', () => {
             // Pequeño delay para dejar que el DOM se asiente
             setTimeout(() => {
                new Swiper(".mySwiper-{{ $id }}", {
                    loop: true,
                    effect: "{{ $effect }}",
                    speed: 800,
                    autoplay: { delay: {{ $delay }} },
                    pagination: { el: ".swiper-pagination", clickable: true },
                    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
                });
             }, 100);
        });
    </script>

    <style>
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 24px !important;
            font-weight: bold;
        }
        .swiper-pagination-bullet-active {
            background: #fe0196 !important;
        }
    </style>
</div>
