@props([
    'cartItems' => [],
    'subtotal' => 0,
    'total' => 0,
    'shipping' => 0,
    'showItems' => false,
])

<div class="bg-base-100 rounded-xl shadow-lg p-6 sticky top-24">
    <h2 class="text-2xl font-bold mb-6 border-b pb-4 font-display">
        Resumen del Pedido
    </h2>

    @if($showItems && count($cartItems) > 0)
        <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
            @foreach($cartItems as $item)
                <div class="flex items-center gap-3">
                    <div class="h-16 w-16 bg-base-200 rounded-md overflow-hidden flex-shrink-0">
                        <img alt="{{ $item['name'] }}" class="h-full w-full object-cover"
                            src="{{ $item['image'] }}" />
                    </div>
                    <div class="flex-grow">
                        <h4 class="text-sm font-semibold">{{ $item['name'] }}</h4>
                        <p class="text-xs text-base-content/70">
                            {{ \Illuminate\Support\Str::limit($item['description'], 30) }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold">
                            ${{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="space-y-4 mb-6">
        <div class="flex justify-between items-center">
            <span class="text-base-content/70">Subtotal</span>
            <span class="font-bold">${{ number_format($subtotal, 2, ',', '.') }}</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-base-content/70">Envío</span>
            <span class="text-success font-bold">Gratis</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-base-content/70">Impuestos</span>
            <span class="font-medium">$0,00</span>
        </div>
    </div>

    <div class="mb-6">
        <x-mary-input placeholder="Ingresá tu cupón" inline>
            <x-slot:label>
                Código de Descuento
            </x-slot:label>
            <x-slot:append>
                <x-mary-button label="Aplicar" class="bg-brand-primary text-white rounded-r" />
            </x-slot:append>
        </x-mary-input>
    </div>

    <div class="border-t pt-4 mb-6">
        <div class="flex justify-between items-center">
            <span class="text-lg font-bold font-display">Total</span>
            <span class="text-3xl font-bold">${{ number_format($total, 2, ',', '.') }}</span>
        </div>
        <p class="text-[10px] mt-1 text-right text-base-content/50 uppercase tracking-tighter">IVA incluido en todos los precios.</p>
    </div>

    @if(isset($actions))
        <div class="mb-6">
            {{ $actions }}
        </div>
    @endif

    <div class="mt-8 flex justify-center gap-6 text-base-content/30">
        <x-mary-icon name="phosphor.credit-card" class="w-8 h-8" />
        <x-mary-icon name="phosphor.bank" class="w-8 h-8" />
        <x-mary-icon name="phosphor.qr-code" class="w-8 h-8" />
    </div>
</div>
