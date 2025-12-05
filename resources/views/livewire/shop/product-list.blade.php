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
                            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                                {{-- Imagen --}}
                                <div class="relative aspect-square overflow-hidden bg-gray-100">
                                    <img src="{{ asset('images/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500">
                                    @if(!$product->is_active)
                                        <div class="absolute inset-0 bg-white/80 flex items-center justify-center backdrop-blur-sm">
                                            <span class="bg-gray-800 text-white px-4 py-2 rounded-full text-sm font-bold uppercase">No disponible</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Contenido --}}
                                <div class="p-6 flex-1 flex flex-col">
                                    <div class="flex-1">
                                        <div class="text-xs font-bold text-brand-primary mb-2 uppercase tracking-wider">{{ $product->category->name }}</div>
                                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-brand-secondary transition-colors">{{ $product->name }}</h3>
                                        <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $product->description }}</p>

                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @if($product->max_flavors > 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <svg class="mr-1.5 h-3 w-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-1.293 5.293a1 1 0 011.414 0 1 1 0 010 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414 1 1 0 011.414 0L10 14.586l2.293-2.293z" clip-rule="evenodd"/></svg>
                                                    Hasta {{ $product->max_flavors }} sabores
                                                </span>
                                            @endif

                                            @if($product->is_delivery_available)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="mr-1.5 h-3 w-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                                    Delivery
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                                                            <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                                                            <div class="flex items-center space-x-2">
                                                                                <button wire:click="decrementQuantity({{ $product->id }})" class="p-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors" title="Restar cantidad">
                                                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                                                                </button>
                                                                                <input type="text" wire:model="quantities.{{ $product->id }}" min="1" class="w-12 text-center border-gray-300 rounded-md shadow-sm focus:border-brand-secondary focus:ring-brand-secondary text-gray-900" readonly value="{{ $quantities[$product->id] ?? 1 }}">
                                                                                <button wire:click="incrementQuantity({{ $product->id }})" class="p-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors" title="Sumar cantidad">
                                                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                                                </button>
                                                                                <button wire:click="addToCart({{ $product->id }})" class="bg-brand-secondary hover:bg-brand-primary text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 ml-2" title="Agregar al carrito">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                                    </svg>
                                                                                </button>
                                                                            </div>                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>