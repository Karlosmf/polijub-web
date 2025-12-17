<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Flavor;
use App\Models\Tag;

new #[Layout('layouts.frontend')] class extends Component {
    public string $selectedFilter = 'Todos';

    public function with(): array
    {
        // Fetch all tags that are associated with active flavors
        $categories = Tag::whereHas('flavors', function (Builder $query) {
            $query->where('is_active', true);
        })->get();

        // Fetch flavors based on filter
        $flavorsQuery = Flavor::where('is_active', true)->with('tags');

        if ($this->selectedFilter !== 'Todos') {
            $flavorsQuery->whereHas('tags', function (Builder $query) {
                $query->where('name', $this->selectedFilter);
            });
        }

        $flavors = $flavorsQuery->get();

        return [
            'categories' => $categories,
            'flavors' => $flavors
        ];
    }

    public function setFilter($category)
    {
        $this->selectedFilter = $category;
    }
}; ?>

<main class="min-h-screen bg-slate-50 font-sans text-text-main pb-20">
    
    {{-- Header Section --}}
    <div class="bg-brand-primary py-12 mb-10">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-4">Nuestros Sabores</h1>
            <p class="text-white/80 text-lg max-w-2xl mx-auto">Descubrí la variedad de sabores artesanales que preparamos con pasión cada día.</p>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-10">
            
            {{-- Sidebar de Filtros --}}
            <div class="w-full lg:w-1/4 space-y-6">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2 border-gray-100">Categorías</h3>
                    <nav class="flex flex-wrap gap-2">
                        <button 
                            wire:click="setFilter('Todos')"
                            class="px-3 py-1 rounded-full text-sm font-bold transition-all duration-200 {{ $selectedFilter === 'Todos' ? 'ring-2 ring-offset-2 ring-brand-primary bg-brand-primary text-white shadow-md' : 'bg-gray-200 text-gray-600 hover:bg-gray-300' }}">
                            Todos
                        </button>
                        @foreach($categories as $category)
                            <button 
                                wire:click="setFilter('{{ $category->name }}')"
                                style="background-color: {{ $category->color ?? '#21C4A5' }}"
                                class="px-3 py-1 rounded-full text-sm text-white font-bold transition-all duration-200 shadow-sm {{ $selectedFilter === $category->name ? 'ring-2 ring-offset-2 ring-gray-400 scale-105' : 'opacity-80 hover:opacity-100 hover:scale-105' }}">
                                {{ ucfirst($category->name) }}
                            </button>
                        @endforeach
                    </nav>
                </div>
            </div>

            {{-- Grid de Sabores --}}
            <div class="w-full lg:w-3/4">
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 align-top">
                    @foreach($flavors as $flavor)
                        {{-- Card Component --}}
                        <article class="group relative flex flex-col bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-primary-light/30">
                            
                            {{-- Image Container --}}
                            <div class="aspect-video w-full overflow-hidden bg-slate-100 relative">
                                <img src="{{ $flavor->image && file_exists(public_path($flavor->image)) ? asset($flavor->image) : asset('images/potehelado.webp') }}" 
                                     alt="{{ $flavor->name }}" 
                                     class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105">
                                
                                {{-- Badges Container --}}
                                <div class="absolute top-3 right-3 flex flex-col gap-1 z-10">
                                    @foreach($flavor->tags as $tag)
                                        <span class="px-2 py-1 text-xs font-bold uppercase tracking-wider rounded text-white shadow-sm" style="background-color: {{ $tag->color ?? '#21C4A5' }}">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                    
                                    {{-- New Badge Logic --}}
                                    @if($flavor->created_at > now()->subDays(30))
                                         <span class="px-2 py-1 text-xs font-bold uppercase tracking-wider rounded text-white shadow-sm bg-accent-pink">
                                            NUEVO
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Content Body --}}
                            <div class="flex flex-1 flex-col p-5">
                                <h3 class="mb-2 text-lg font-bold text-slate-800 line-clamp-2 group-hover:text-primary-light transition-colors font-display">
                                    {{ $flavor->name }}
                                </h3>
                                <p class="mb-4 flex-1 text-sm text-slate-600 line-clamp-3 leading-relaxed">
                                    {{ $flavor->description ?? 'Delicioso sabor artesanal elaborado con ingredientes de primera calidad.' }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>