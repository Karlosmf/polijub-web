<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Mary\Traits\Toast;

new #[Layout('layouts.frontend')] class extends Component {
    use Toast;

    public $paymentMethod = 'card'; // card, mp, transfer, cash
    public array $enabledMethods = [];
    public $cardNumber;
    public $cardName;
    public $cardExpiry;
    public $cardCvc;
    public $saveCard = false;
    
    public $subtotal = 0;
    public $shipping = 0;
    public $total = 0;
    public $discount = 0;
    public $cartItems = [];
    public $appliedCoupon = null;

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

        // Load enabled payment methods
        $settingsPath = base_path('config/app_settings.json');
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            $this->enabledMethods = $settings['payments'] ?? ['card' => true, 'mp' => true, 'transfer' => true, 'cash' => true];
        }

        // Ensure default payment method is an enabled one
        if (isset($this->enabledMethods[$this->paymentMethod]) && !$this->enabledMethods[$this->paymentMethod]) {
            foreach ($this->enabledMethods as $method => $enabled) {
                if ($enabled) {
                    $this->paymentMethod = $method;
                    break;
                }
            }
        }

        $couponId = session()->get('applied_coupon_id');
        if ($couponId) {
            $this->appliedCoupon = Coupon::find($couponId);
            if ($this->appliedCoupon && !$this->appliedCoupon->isValid(auth()->user())) {
                session()->forget('applied_coupon_id');
                $this->appliedCoupon = null;
                $this->warning('El cupón ya no es válido.');
            }
        }

        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = array_reduce($this->cartItems, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
        
        $this->discount = 0;
        if ($this->appliedCoupon) {
            $this->discount = $this->appliedCoupon->calculateDiscount($this->subtotal, $this->cartItems);
        }

        $this->total = max(0, $this->subtotal - $this->discount + $this->shipping);
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

        // Final validation of coupon before saving
        if ($this->appliedCoupon && !$this->appliedCoupon->isValid(auth()->user())) {
            $this->error('El cupón ya no es válido. Se ha quitado de tu pedido.');
            session()->forget('applied_coupon_id');
            $this->appliedCoupon = null;
            $this->calculateTotals();
            return;
        }

        DB::transaction(function () use ($cart, $delivery) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'branch_id' => null, // Default or selected branch
                'coupon_id' => $this->appliedCoupon?->id,
                'discount_amount' => $this->discount,
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

            $totalPointsEarned = 0;
            $freeProductId = ($this->appliedCoupon && $this->appliedCoupon->type === 'fixed_product') 
                             ? $this->appliedCoupon->product_id 
                             : null;

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

                // Calculate points for this item
                $product = \App\Models\Product::find($item['id']);
                if ($product && $product->points > 0) {
                    $qtyForPoints = $item['quantity'];
                    // If this item is the free one from a coupon, subtract 1 from the quantity that grants points
                    if ($freeProductId == $item['id']) {
                        $qtyForPoints = max(0, $qtyForPoints - 1);
                    }
                    $totalPointsEarned += ($product->points * $qtyForPoints);
                }
            }

            // Assign points to user if logged in
            if (auth()->check() && $totalPointsEarned > 0) {
                \App\Models\PointTransaction::earn(auth()->user(), $totalPointsEarned, $order->id);
            }

            // Mark coupon as used
            if ($this->appliedCoupon) {
                $this->appliedCoupon->increment('uses_count');
                if (auth()->check()) {
                    $this->appliedCoupon->users()->attach(auth()->id());
                }
            }
        });

        session()->forget(['cart', 'delivery_info', 'applied_coupon_id']);
        $this->dispatch('cart-updated');
        $this->redirect(route('checkout.success'), navigate: true);
    }
}; ?>

<div>
    <div class="flex-grow container mx-auto px-4 py-8 lg:py-12">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold mb-4 font-display text-brand-primary">Proceso de Pago</h1>
            <x-checkout-steps step="3" />
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-2/3">
                <div class="bg-white dark:bg-base-100 rounded-xl shadow-lg p-6 lg:p-8 transition-colors">
                    <h2 class="text-2xl font-bold mb-6 flex items-center font-display text-brand-primary">
                        <x-mary-icon name="phosphor.credit-card" class="text-brand-primary mr-3" />
                        Detalles de Pago
                    </h2>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                        @php
                            $allMethods = [
                                'card' => ['icon' => 'phosphor.credit-card', 'label' => 'Tarjeta'], 
                                'mp' => ['icon' => 'phosphor.wallet', 'label' => 'Mercado Pago'], 
                                'transfer' => ['icon' => 'phosphor.qr-code', 'label' => 'Transferencia'], 
                                'cash' => ['icon' => 'phosphor.money', 'label' => 'Efectivo']
                            ];
                        @endphp
                        @foreach($allMethods as $method => $data)
                            @if(isset($enabledMethods[$method]) && $enabledMethods[$method])
                                <button wire:click="setPaymentMethod('{{ $method }}')" 
                                    class="flex flex-col items-center justify-center p-4 border rounded-xl transition-all {{ $paymentMethod === $method ? 'border-2 border-brand-primary bg-brand-primary/5 text-brand-primary font-bold' : 'border-base-300 text-base-content/50 hover:bg-base-200' }}">
                                    <x-mary-icon name="{{ $data['icon'] }}" class="mb-1 w-6 h-6" />
                                    <span class="text-xs">{{ $data['label'] }}</span>
                                </button>
                            @endif
                        @endforeach
                    </div>

                    @if($paymentMethod === 'card')
                    <form wire:submit="placeOrder" class="space-y-6">
                        <div class="flex items-center space-x-2 mb-4 text-brand-primary">
                            <span class="text-xs text-base-content/50 mr-2 uppercase font-bold tracking-widest">Aceptamos:</span>
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
                    <x-mary-button label="Volver a envíos" icon="phosphor.arrow-left" link="{{ route('checkout.delivery') }}" class="btn-ghost text-base-content/50 font-bold" />
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
                    :discount="$discount"
                    :appliedCoupon="$appliedCoupon"
                >
                    <x-slot:actions>
                        <x-mary-button wire:click="placeOrder" 
                            label="Realizar Pedido" 
                            icon-right="phosphor.star-duotone"
                            class="bg-brand-primary text-white text-lg w-full shadow-lg" />
                        
                        <div class="flex items-center justify-center mt-4 text-[10px] text-base-content/40 uppercase tracking-widest font-bold">
                            <x-mary-icon name="phosphor.lock" class="w-3 h-3 mr-1" />
                            Pago 100% Seguro
                        </div>
                    </x-slot:actions>
                </x-order-summary>
            </div>
        </div>
        
        <div class="mt-16 bg-base-100 rounded-xl shadow-sm p-8 text-center border-t-4 border-brand-primary transition-all hover:shadow-md">
            <h3 class="text-2xl text-brand-primary font-bold mb-2 font-display">¿Necesitas ayuda con tu pedido?</h3>
            <p class="text-base-content/70 mb-6">Nuestro equipo de soporte está disponible todos los días.</p>
            <div class="flex justify-center gap-4 flex-wrap">
                <x-mary-button label="03482 42-8908" icon="phosphor.phone" class="btn-ghost bg-base-200 rounded-full font-bold" />
                <x-mary-button label="HeladoPolijub@gmail.com" icon="phosphor.envelope" class="btn-ghost bg-base-200 rounded-full font-bold" />
            </div>
        </div>
    </div>
</div>
