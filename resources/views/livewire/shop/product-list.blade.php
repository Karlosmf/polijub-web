<div class="min-h-screen bg-gray-50 font-sans">
    {{-- Header de la Tienda --}}
    <div class="bg-brand-primary py-12 mb-10">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white tracking-wider uppercase">Nuestros Productos</h1>
            <p class="text-white/80 mt-4 text-lg">Descubrí la variedad de sabores y postres que tenemos para vos.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 pb-20">
        <div class="flex flex-col lg:flex-row gap-10">
            {{-- Sidebar de Categorías --}}
            <div class="w-full lg:w-1/4 space-y-6">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2 border-gray-100">Categorías</h3>
                    <nav class="space-y-2">
                        <button wire:click="$set('selectedCategory', null)"
                            class="w-full text-left px-4 py-3 rounded-lg transition-all duration-200 {{ is_null($selectedCategory) ? 'bg-brand-secondary text-white font-semibold shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-brand-primary' }}">
                            Todos los Productos
                        </button>
                        @foreach ($categories as $category)
                            <button wire:click="$set('selectedCategory', {{ $category->id }})"
                                class="w-full text-left px-4 py-3 rounded-lg transition-all duration-200 {{ $selectedCategory === $category->id ? 'bg-brand-secondary text-white font-semibold shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-brand-primary' }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </nav>
                </div>
            </div>

            {{-- Grilla de Productos --}}
            <div class="w-full lg:w-3/4">
                @if($products->isEmpty())
                    <div class="text-center py-20">
                        <p class="text-gray-500 text-xl">No se encontraron productos en esta categoría.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                        @foreach ($products as $product)
                            <div
                                class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                                {{-- Imagen --}}
                                <div class="relative aspect-square overflow-hidden bg-gray-100">
                                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500">
                                    @if(!$product->is_active)
                                        <div class="absolute inset-0 bg-white/80 flex items-center justify-center backdrop-blur-sm">
                                            <span
                                                class="bg-gray-800 text-white px-4 py-2 rounded-full text-sm font-bold uppercase">No
                                                disponible</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Contenido --}}
                                <div class="p-6 flex-1 flex flex-col">
                                    <div class="flex-1">
                                        <div class="text-xs font-bold text-brand-primary mb-2 uppercase tracking-wider">
                                            {{ $product->category->name }}</div>
                                        <h3
                                            class="text-xl font-bold text-gray-800 mb-2 group-hover:text-brand-secondary transition-colors">
                                            {{ $product->name }}</h3>
                                        <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $product->description }}</p>

                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @if($product->max_flavors > 0)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $product->max_flavors }} sabor{{ $product->max_flavors > 1 ? 'es' : '' }}
                                                </span>
                                            @endif

                                            @if($product->is_delivery_available)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <x-heroicon-o-truck class="w-4 h-4 mr-1" />
                                                    Delivery
                                                </span>
                                            @endif
                                            <span
                                            class="text-2xl font-bold text-gray-900 w-full text-left">${{ number_format($product->price, 2, ",", ".") }}</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        
                                        <div class="flex items-center space-x-2">
                                        <div class=" border border-gray-200 rounded-full p-2">
                                        <button wire:click="decrementQuantity({{ $product->id }})"
                                                class="p-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors"
                                                title="Restar cantidad">
                                                <x-heroicon-o-minus class="w-4 h-4" />
                                            </button>
                                            <input type="text" wire:model="quantities.{{ $product->id }}" min="1"
                                                class="w-12 text-center text-xl focus:border-brand-secondary focus:ring-brand-secondary text-gray-900"
                                                readonly value="{{ $quantities[$product->id] ?? 1 }}">
                                            <button wire:click="incrementQuantity({{ $product->id }})"
                                                class="p-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors"
                                                title="Sumar cantidad">
                                                <x-heroicon-o-plus class="w-4 h-4" />
                                            </button>
                                        </div>
                                        @if($product->max_flavors > 0)
                                            <button wire:click="openFlavorSelectionModal({{ $product->id }}, '{{ $product->name }}', {{ $quantities[$product->id] ?? 1 }}, {{ $product->max_flavors }})"
                                                class="bg-brand-secondary hover:bg-brand-primary text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 ml-2"
                                                title="Seleccionar sabores y agregar al carrito">
                                                <x-heroicon-o-sparkles class="w-6 h-6" /> {{-- Sparkle icon for flavor selection --}}
                                            </button>
                                        @else
                                            <button wire:click="addToCart({{ $product->id }})"
                                                class="bg-brand-secondary hover:bg-brand-primary text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 ml-2"
                                                title="Agregar al carrito">
                                                <x-heroicon-o-shopping-cart class="w-6 h-6" />
                                            </button>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    <livewire:shop.flavor-selection-modal />
</div>