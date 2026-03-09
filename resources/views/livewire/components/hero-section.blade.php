<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\File;

new class extends Component {
    public $promotion = [];

    public function mount()
    {
        $path = storage_path('app/public/hero/promotion.json');
        if (File::exists($path)) {
            $data = json_decode(File::get($path), true);
            $this->promotion = array_merge([
                'show_subtitle' => true,
                'show_button' => true,
                'content_alignment' => 'justify-end', // Default to right
                'vertical_alignment' => 'items-center', // Default to middle
                'overlays' => []
            ], $data ?? []);
        } else {
            // Fallback
            $this->promotion = [
                'title' => '#LOQUEQUIERAS',
                'description' => 'Para este #MESDELAMOR preparamos un montón de cosas ricas para disfrutar con todo el amor...,',
                'subtitle' => 'EL AMOR POR EL HELADO!!!',
                'button_text' => 'Ver más',
                'button_url' => '#',
                'image_path' => 'images/nuevospng/petalos.webp',
                'secondary_image_path' => 'heroimg.gif',
                'title_color' => '#fe0196',
                'subtitle_color' => '#fe0196',
                'bg_color' => 'rgba(220, 215, 202, 0.9)', // Slightly transparent background
                'show_subtitle' => true,
                'show_button' => true,
                'content_alignment' => 'justify-end',
                'vertical_alignment' => 'items-center',
                'overlays' => []
            ];
        }
    }
}; ?>

<section class="relative min-h-[50vh] flex items-center bg-gray-200 overflow-hidden">
    {{-- Full Width Background Image --}}
    @php
        $mainImg = str_starts_with($promotion['image_path'], 'images/') 
            ? asset($promotion['image_path']) 
            : asset('storage/' . $promotion['image_path']);
    @endphp
    <div class="absolute inset-0 z-0">
        <img src="{{ $mainImg }}" alt="Hero Background" class="w-full h-full object-cover object-center">
    </div>

    {{-- Content Overlay Container --}}
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex {{ $promotion['content_alignment'] }} {{ $promotion['vertical_alignment'] ?? 'items-center' }}">
        
        {{-- Text Box --}}
        <div class="max-w-lg p-8 rounded-xl shadow-2xl backdrop-blur-sm" style="background-color: {{ $promotion['bg_color'] }}">
            <div class="text-center">
                <h2 class="text-4xl font-extrabold tracking-tight" style="color: {{ $promotion['title_color'] }}">
                    {{ $promotion['title'] }}
                </h2>
                <p class="mt-4 text-base text-gray-800 font-medium">
                    {{ $promotion['description'] }}
                </p>
                @if($promotion['show_subtitle'])
                <span class="mt-4 block text-2xl font-bold uppercase" style="color: {{ $promotion['subtitle_color'] }}">
                    {{ $promotion['subtitle'] }}
                </span>
                @endif

                @if($promotion['show_button'])
                <a href="{{ $promotion['button_url'] }}"
                    style="background-color: {{ $promotion['title_color'] }}"
                    class="mt-8 inline-block text-white font-bold py-3 px-10 rounded-[5px] hover:bg-opacity-80 transition-all duration-300">
                    {{ $promotion['button_text'] }}
                </a>
                @endif
            </div>
        </div>

    </div>
    
    {{-- Independent Overlays --}}
    @foreach($promotion['overlays'] ?? [] as $overlay)
        @if(($overlay['is_visible'] ?? true) && !empty($overlay['image_path']))
            @php
                $overlaySrc = str_contains($overlay['image_path'], '.') 
                    ? (str_starts_with($overlay['image_path'], 'hero/') ? asset('storage/' . $overlay['image_path']) : asset($overlay['image_path']))
                    : asset($overlay['image_path']);
                
                $posX = $overlay['position_x'] ?? 50;
                $posY = $overlay['position_y'] ?? 50;
            @endphp
            {{-- Using pointer-events-none so they don't block clicks on buttons behind them --}}
            <div class="absolute z-20 pointer-events-none hidden md:block animate-bounce-slow" 
                 style="left: {{ $posX }}%; top: {{ $posY }}%; transform: translate(-50%, -50%);">
                <img src="{{ $overlaySrc }}" alt="Overlay Element" class="w-32 md:w-48 h-auto drop-shadow-xl">
            </div>
        @endif
    @endforeach
</section>