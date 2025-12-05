<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    public string $selectedFilter = 'Todos';

    public function with(): array
    {
        $allFlavors = [
            'Cremas' => ['Americana', 'Vainilla', 'Crema Rusa', 'Tramontana', 'Granizado', 'Cereza a la Crema'],
            'Chocolates' => ['Chocolate', 'Chocolate con Almendras', 'Chocolate Suizo', 'Chocolate Amargo', 'Chocolate Polijub'],
            'Dulces de Leche' => ['Dulce de Leche', 'Dulce de Leche Granizado', 'Dulce de Leche con Nuez', 'Super Dulce de Leche'],
            'Frutales' => ['Frutilla', 'Limón', 'Naranja', 'Durazno', 'Ananá', 'Frambuesa'],
        ];

        // Flatten for display if 'Todos' is selected, or filter by category
        $displayFlavors = [];
        if ($this->selectedFilter === 'Todos') {
            foreach ($allFlavors as $category => $flavors) {
                foreach ($flavors as $flavor) {
                    $displayFlavors[] = ['name' => $flavor, 'category' => $category];
                }
            }
        } else {
            if (isset($allFlavors[$this->selectedFilter])) {
                foreach ($allFlavors[$this->selectedFilter] as $flavor) {
                    $displayFlavors[] = ['name' => $flavor, 'category' => $this->selectedFilter];
                }
            }
        }

        return [
            'categories' => array_keys($allFlavors),
            'flavors' => $displayFlavors
        ];
    }

    public function setFilter($category)
    {
        $this->selectedFilter = $category;
    }
}; ?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-slate-50 min-h-screen font-sans text-text-main">
    
    {{-- Header Section (Optional but good for context) --}}
    <div class="mb-10 text-center">
        <h1 class="text-4xl md:text-5xl font-display font-bold text-text-heading mb-4">Nuestros Sabores</h1>
        <p class="text-lg text-text-muted max-w-2xl mx-auto">Descubrí la variedad de sabores artesanales que preparamos con pasión cada día.</p>
    </div>

    {{-- Filter Bar Wrapper --}}
    <section class="sticky top-20 z-40 bg-slate-50/95 backdrop-blur py-4 mb-8 border-b border-slate-200">
        <div class="flex flex-wrap justify-center gap-3">
            <button 
                wire:click="setFilter('Todos')"
                class="px-4 py-2 rounded-full text-sm font-semibold cursor-pointer transition-all duration-200 {{ $selectedFilter === 'Todos' ? 'bg-primary text-white shadow-md' : 'bg-background-surface text-text-muted border border-slate-200 hover:bg-white' }}">
                Todos
            </button>
            @foreach($categories as $category)
                <button 
                    wire:click="setFilter('{{ $category }}')"
                    class="px-4 py-2 rounded-full text-sm font-semibold cursor-pointer transition-all duration-200 {{ $selectedFilter === $category ? 'bg-primary text-white shadow-md' : 'bg-background-surface text-text-muted border border-slate-200 hover:bg-white' }}">
                    {{ $category }}
                </button>
            @endforeach
        </div>
    </section>

    {{-- Grid Wrapper --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 align-top">
        @foreach($flavors as $flavor)
            {{-- Card Component --}}
            <article class="group relative flex flex-col bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-primary-light/30">
                
                {{-- Image Container --}}
                <div class="aspect-video w-full overflow-hidden bg-slate-100 relative">
                    {{-- Placeholder image logic based on category --}}
                    @php
                        $image = match($flavor['category']) {
                            'Chocolates' => 'helados.webp',
                            'Frutales' => 'helados.webp', // Should ideally have different images
                            default => 'potehelado.webp',
                        };
                    @endphp
                    <img src="{{ asset('images/' . $image) }}" 
                         alt="{{ $flavor['name'] }}" 
                         class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105">
                    
                    {{-- Badges Container --}}
                    <div class="absolute top-3 right-3 flex flex-col gap-1 z-10">
                        <span class="px-2 py-1 text-xs font-bold uppercase tracking-wider rounded text-white shadow-sm bg-secondary">
                            {{ $flavor['category'] }}
                        </span>
                        {{-- Example of conditional badge --}}
                        @if($loop->iteration <= 3 && $selectedFilter === 'Todos')
                             <span class="px-2 py-1 text-xs font-bold uppercase tracking-wider rounded text-white shadow-sm bg-status-success">
                                NUEVO
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Content Body --}}
                <div class="flex flex-1 flex-col p-5">
                    <h3 class="mb-2 text-lg font-bold text-slate-800 line-clamp-2 group-hover:text-primary-light transition-colors font-display">
                        {{ $flavor['name'] }}
                    </h3>
                    <p class="mb-4 flex-1 text-sm text-slate-600 line-clamp-3 leading-relaxed">
                        Delicioso sabor artesanal de {{ strtolower($flavor['name']) }}, elaborado con ingredientes de primera calidad.
                    </p>
                    
                    {{-- Footer Actions --}}
                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                        <button class="text-sm font-semibold text-primary-light hover:text-primary-dark flex items-center gap-1 transition-colors">
                            Ver detalle
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</main>
