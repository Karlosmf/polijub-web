<div class="min-h-screen bg-gray-50 py-12 font-sans">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center uppercase tracking-wider">Tu Carrito de Compras</h1>

        @if(empty($cartItems))
            <div class="bg-white rounded-xl shadow-sm p-12 text-center max-w-2xl mx-auto">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                    <x-heroicon-o-shopping-bag class="w-12 h-12 text-gray-400" />
                </div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">Tu carrito está vacío</h2>
                <p class="text-gray-500 mb-8">¡Descubre nuestros deliciosos helados y postres!</p>
                <a href="{{ route('shop.products') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-brand-primary hover:bg-brand-secondary md:text-lg transition-colors shadow-lg hover:shadow-xl">
                    Ir a la Tienda
                </a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Cart Items List --}}
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="divide-y divide-gray-100">
                            @foreach($cartItems as $item)
                                <div class="p-6 flex flex-col sm:flex-row items-center gap-6">
                                    {{-- Image --}}
                                    <div class="w-full sm:w-24 h-24 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex-1 w-full text-center sm:text-left">
                                        <h3 class="text-lg font-bold text-gray-900">{{ $item['name'] }}</h3>
                                        <p class="text-sm text-gray-500 line-clamp-1">{{ $item['description'] }}</p>
                                        @if(!empty($item['flavor_names']))
                                            <div class="mt-2 text-sm text-brand-primary font-medium bg-brand-primary/5 p-2 rounded-lg inline-block">
                                                <span class="font-bold">Sabores:</span> {{ $item['flavor_names'] }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Quantity & Price --}}
                                    <div class="flex flex-col items-center sm:items-end gap-2">
                                        <div class="flex items-center border border-gray-200 rounded-full">
                                            <button wire:click="decrementQuantity('{{ $item['unique_id'] }}')" class="p-2 text-gray-600 hover:text-brand-primary transition-colors">
                                                <x-heroicon-o-minus class="w-4 h-4" />
                                            </button>
                                            <span class="w-8 text-center font-semibold text-gray-900">{{ $item['quantity'] }}</span>
                                            <button wire:click="incrementQuantity('{{ $item['unique_id'] }}')" class="p-2 text-gray-600 hover:text-brand-primary transition-colors">
                                                <x-heroicon-o-plus class="w-4 h-4" />
                                            </button>
                                        </div>
                                        <div class="text-lg font-bold text-gray-900">
                                            ${{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                                        </div>
                                        <button wire:click="removeItem('{{ $item['unique_id'] }}')" class="text-xs text-red-500 hover:text-red-700 underline mt-1">
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Summary --}}
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b pb-4">Resumen del Pedido</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center text-gray-600">
                                <span>Subtotal</span>
                                <span>${{ number_format($total, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-600">
                                <span>Envío</span>
                                <span class="text-xs text-gray-500">(Se calcula en el siguiente paso)</span>
                            </div>
                            <div class="flex justify-between items-center text-xl font-bold text-gray-900 pt-4 border-t border-gray-100">
                                <span>Total</span>
                                <span>${{ number_format($total, 2, ',', '.') }}</span>
                            </div>
                        </div>

                        <button wire:click="checkout" class="w-full bg-brand-secondary hover:bg-brand-primary text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 block text-center">
                            FINALIZAR COMPRA
                        </button>
                        
                        <a href="{{ route('shop.products') }}" class="block text-center mt-4 text-brand-primary hover:text-brand-secondary font-semibold text-sm">
                            Seguir comprando
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>