<?php

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.frontend')] class extends Component {
    public $paymentMethod = 'card'; // card, mp, transfer, cash
    public $cardNumber;
    public $cardName;
    public $cardExpiry;
    public $cardCvc;
    public $saveCard = false;
    
    public $subtotal = 0;
    public $shipping = 0;
    public $total = 0;
    public $cartItems = [];

    public function mount() {
        $this->cartItems = session()->get('cart', []);
        
        if (empty($this->cartItems)) {
            $this->redirect(route('checkout.cart'), navigate: true);
            return;
        }

        if (!session()->has('delivery_info')) {
            $this->redirect(route('checkout.delivery'), navigate: true);
            return;
        }

        $this->subtotal = array_reduce($this->cartItems, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
        $this->total = $this->subtotal + $this->shipping;
    }

    public function setPaymentMethod($method)
    {
        $this->paymentMethod = $method;
    }

    public function placeOrder()
    {
        $cart = session()->get('cart', []);
        $delivery = session()->get('delivery_info', []);

        if (empty($cart)) {
            $this->redirect(route('checkout.cart'), navigate: true);
            return;
        }

        DB::transaction(function () use ($cart, $delivery) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'branch_id' => null, // Default or selected branch
                'total' => $this->total,
                'status' => 'pending',
                'guest_email' => $delivery['email'] ?? null,
                'guest_phone' => $delivery['phone'] ?? null,
                'guest_name' => $delivery['firstname'] ?? null,
                'guest_lastname' => $delivery['lastname'] ?? null,
                'address' => $delivery['address'] ?? null,
                'city' => $delivery['city'] ?? null,
                'province' => $delivery['province'] ?? null,
                'zip' => $delivery['zip'] ?? null,
                'notes' => $delivery['notes'] ?? null,
                'payment_method' => $this->paymentMethod,
            ]);

            foreach ($cart as $item) {
                $options = [];
                if (!empty($item['flavors'])) {
                    $options['flavors'] = $item['flavors'];
                    $options['flavor_names'] = $item['flavor_names'] ?? '';
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'options' => !empty($options) ? $options : null,
                ]);
            }
        });

        session()->forget(['cart', 'delivery_info']);
        // session()->flash('success', 'Pedido realizado con éxito!'); // Handled by the success page now
        $this->dispatch('cart-updated');
        $this->redirect(route('checkout.success'), navigate: true);
    }
}; ?>

<div>
    <div class="flex-grow container mx-auto px-4 py-8 lg:py-12">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold mb-4 font-body">Proceso de Pago</h1>
            <x-checkout-steps step="3" />
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-2/3">
                <div class="bg-white dark:bg-base-100 rounded-xl shadow-lg p-6 lg:p-8 transition-colors">
                    <h2 class="text-2xl font-bold mb-6 flex items-center font-body">
                        <x-mary-icon name="phosphor.credit-card" class="text-brand-primary mr-3" />
                        Detalles de Pago
                    </h2>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                        @foreach(['card' => ['icon' => 'phosphor.credit-card', 'label' => 'Tarjeta'], 
                                  'mp' => ['icon' => 'phosphor.wallet', 'label' => 'Mercado Pago'], 
                                  'transfer' => ['icon' => 'phosphor.qr-code', 'label' => 'Transferencia'], 
                                  'cash' => ['icon' => 'phosphor.money', 'label' => 'Efectivo']] as $method => $data)
                            <button wire:click="setPaymentMethod('{{ $method }}')" 
                                class="flex flex-col items-center justify-center p-4 border rounded-xl transition-all {{ $paymentMethod === $method ? 'border-2 border-brand-primary bg-brand-primary/5 text-brand-primary font-bold' : 'border-base-300 text-base-content/50 hover:bg-base-200' }}">
                                <x-mary-icon name="{{ $data['icon'] }}" class="mb-1 w-6 h-6" />
                                <span class="text-xs">{{ $data['label'] }}</span>
                            </button>
                        @endforeach
                    </div>

                    @if($paymentMethod === 'card')
                    <form wire:submit="placeOrder" class="space-y-6">
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="text-xs text-base-content/50 mr-2">Aceptamos:</span>
                            <div class="flex space-x-2 opacity-70">
                                <x-mary-icon name="phosphor.credit-card" class="w-6 h-6" />
                            </div>
                        </div>
                        
                        <x-mary-input label="Número de Tarjeta" wire:model="cardNumber" icon="phosphor.credit-card" placeholder="0000 0000 0000 0000" />
                        
                        <x-mary-input label="Nombre del Titular" wire:model="cardName" placeholder="Como aparece en la tarjeta" />
                        
                        <div class="grid grid-cols-2 gap-6">
                            <x-mary-input label="Fecha de Caducidad" wire:model="cardExpiry" placeholder="MM / AA" />
                            <x-mary-input label="CVV" wire:model="cardCvc" placeholder="123" hint="3 dígitos al reverso" />
                        </div>
                        
                        <x-mary-toggle label="Guardar esta tarjeta para futuras compras" wire:model="saveCard" />
                    </form>
                    @else
                        <div class="text-center py-8 text-base-content/50">
                            <p>Procesamiento con {{ strtoupper($paymentMethod) }} implementado próximamente.</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-start">
                    <x-mary-button label="Volver a envíos" icon="phosphor.arrow-left" link="{{ route('checkout.delivery') }}" class="btn-ghost text-base-content/50 font-medium" />
                </div>
            </div>

            <!-- Summary Sidebar -->
            <div class="w-full lg:w-1/3">
                <x-order-summary 
                    :cartItems="$cartItems"
                    :subtotal="$subtotal" 
                    :total="$total"
                    :shipping="0"
                    :showItems="true"
                >
                    <x-slot:actions>
                        <x-mary-button wire:click="placeOrder" 
                            label="Realizar Pedido" 
                            icon-right="phosphor.star-duotone"
                            class="bg-brand-primary text-white text-lg w-full shadow-lg" />
                        
                        <div class="flex items-center justify-center mt-4 text-[10px] text-base-content/40 uppercase tracking-widest">
                            <x-mary-icon name="phosphor.lock" class="w-3 h-3 mr-1" />
                            Pago 100% Seguro
                        </div>
                    </x-slot:actions>
                </x-order-summary>
            </div>
        </div>
        
        <div class="mt-16 bg-base-100 rounded-xl shadow-sm p-8 text-center">
            <h3 class="text-2xl text-brand-primary font-bold mb-2 font-body">¿Necesitas ayuda con tu pedido?</h3>
            <p class="text-base-content/70 mb-6">Nuestro equipo de soporte está disponible todos los días.</p>
            <div class="flex justify-center gap-4 flex-wrap">
                <x-mary-button label="03482 42-8908" icon="phosphor.phone" class="btn-ghost bg-base-200 rounded-full" />
                <x-mary-button label="HeladoPolijub@gmail.com" icon="phosphor.envelope" class="btn-ghost bg-base-200 rounded-full" />
            </div>
        </div>
    </div>
</div>