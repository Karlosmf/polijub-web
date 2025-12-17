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
        session()->flash('success', 'Pedido realizado con éxito!');
        $this->dispatch('cart-updated');
        $this->redirect('/');
    }
}; ?>

<div class="font-sans text-gray-900 bg-[#F8F9FA] dark:bg-gray-900 min-h-screen flex flex-col transition-colors duration-200">
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <style>
        .font-body { font-family: 'Poppins', sans-serif; }
    </style>

    <div class="flex-grow container mx-auto px-4 py-8 lg:py-12">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4 font-body">Proceso de Pago</h1>
            <div class="flex justify-center items-center space-x-4 text-sm font-medium">
                <span class="text-gray-400 dark:text-gray-500 flex items-center">
                    <span class="bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-full w-6 h-6 flex items-center justify-center mr-2">1</span>
                    Carrito
                </span>
                <span class="w-12 h-px bg-gray-300 dark:bg-gray-700"></span>
                <span class="text-gray-400 dark:text-gray-500 flex items-center">
                    <span class="bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-full w-6 h-6 flex items-center justify-center mr-2">2</span>
                    Envío
                </span>
                <span class="w-12 h-px bg-gray-300 dark:bg-gray-700"></span>
                <span class="text-[#0FB593] flex items-center">
                    <span class="bg-[#0FB593] text-white rounded-full w-6 h-6 flex items-center justify-center mr-2">3</span>
                    Pago
                </span>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-2/3">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 lg:p-8 border border-gray-100 dark:border-gray-700 transition-colors">
                    <h2 class="text-2xl font-bold mb-6 flex items-center text-gray-800 dark:text-white font-body">
                        <span class="material-icons text-[#0FB593] mr-3">credit_card</span>
                        Detalles de Pago
                    </h2>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                        <button wire:click="setPaymentMethod('card')" class="flex flex-col items-center justify-center p-4 border rounded-lg transition-all {{ $paymentMethod === 'card' ? 'border-2 border-[#0FB593] bg-[#0FB593]/5 text-[#0FB593] font-bold' : 'border-gray-200 dark:border-gray-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                            <span class="material-icons mb-1">credit_card</span>
                            Tarjeta
                        </button>
                        <button wire:click="setPaymentMethod('mp')" class="flex flex-col items-center justify-center p-4 border rounded-lg transition-all {{ $paymentMethod === 'mp' ? 'border-2 border-[#0FB593] bg-[#0FB593]/5 text-[#0FB593] font-bold' : 'border-gray-200 dark:border-gray-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                            <span class="material-icons mb-1">account_balance_wallet</span>
                            Mercado Pago
                        </button>
                        <button wire:click="setPaymentMethod('transfer')" class="flex flex-col items-center justify-center p-4 border rounded-lg transition-all {{ $paymentMethod === 'transfer' ? 'border-2 border-[#0FB593] bg-[#0FB593]/5 text-[#0FB593] font-bold' : 'border-gray-200 dark:border-gray-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                            <span class="material-icons mb-1">qr_code</span>
                            Transferencia
                        </button>
                        <button wire:click="setPaymentMethod('cash')" class="flex flex-col items-center justify-center p-4 border rounded-lg transition-all {{ $paymentMethod === 'cash' ? 'border-2 border-[#0FB593] bg-[#0FB593]/5 text-[#0FB593] font-bold' : 'border-gray-200 dark:border-gray-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                            <span class="material-icons mb-1">payments</span>
                            Efectivo
                        </button>
                    </div>

                    @if($paymentMethod === 'card')
                    <form wire:submit="placeOrder" class="space-y-6">
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">Aceptamos:</span>
                            <div class="flex space-x-2">
                                <div class="w-10 h-7 bg-gray-100 dark:bg-gray-600 rounded flex items-center justify-center overflow-hidden">
                                    <img alt="Mastercard" class="h-4 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBvZEuO20QP3nkB5-UzuqlQVrYPJpy6RGNGH2UvxdVbDyfbxfg39shoLdp8NqT091tmOb1LCMM57XQLmG9rkW0_hk5jMsOiakzURQI0qTMRhQiQEVR1W-Vy8PB48hzLDBIP-qUgfID6iXVh04lkeJ9qKa6KjL8VJYkhyLmBgnd0X7Bkrtxha1sUt6HoLNQw_2QiJUw4COW26gJDwOhNfmcADbHTG4TYOTYIvNR6SfFlGYSy4CG-cy9BBRSa3wwZrlaQQ6lyXaAzPgDz"/>
                                </div>
                                <div class="w-10 h-7 bg-gray-100 dark:bg-gray-600 rounded flex items-center justify-center overflow-hidden">
                                    <img alt="Visa" class="h-3 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBkEBhyHb_L8TZNS2brhzDK14CZvLJH9e8NLfaYYMBdN_eQF3SZTa2h_ZQQIEMC5XVUEcbrKf8G2OiwQv3JwpYJNDTactOkLWiydvlb0ZTDzIUY9D6eY_lg7XtG8K-f20znDxnH2ccvk67jrSB7bx3nRcRYuX0a1OVPnH1gtWlL_Jy5TUgwXSxBeioWdxFLVAALSUpLqDg0VLQ9ylH_jBUco75PxYHQeiCkQNZO5bOFD-ZMKHleZfcWFo2tsEZ_36rrVbDr075CX3mk"/>
                                </div>
                                <div class="w-10 h-7 bg-gray-100 dark:bg-gray-600 rounded flex items-center justify-center overflow-hidden">
                                    <img alt="Amex" class="h-3 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBWnm1nJ2uvCOCYVD1xKyjV-gPiNi9oWaYD9Fv5lQbEqlhOESSXKKuWFKfHzwzL9ZY8EZaPfUEAeQgORS_2m3Hy0CsgWvvqKVn1dgrx6-39WS9ccdOv7hcibKR-uf4hOazxCrWPLxOW_8lTYUxS0ZqosLEkrxf9qkYjtHLwn7lqTJ9B26UPOlYjgMeQVf7Ysco2EZU6oybWbLRCArp_l84MyXhXIucTdfuhp39RCzf3LUjxmXjVO8weedKPkmt5IZRENR3Ae_p7WnAX"/>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="card-number">Número de Tarjeta</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-icons text-gray-400 text-xl">payment</span>
                                </div>
                                <input wire:model="cardNumber" class="block w-full pl-10 pr-3 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-lg focus:ring-[#0FB593] focus:border-[#0FB593] sm:text-sm shadow-sm" id="card-number" placeholder="0000 0000 0000 0000" type="text"/>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="card-name">Nombre del Titular</label>
                            <input wire:model="cardName" class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-lg focus:ring-[#0FB593] focus:border-[#0FB593] sm:text-sm shadow-sm" id="card-name" placeholder="Como aparece en la tarjeta" type="text"/>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="card-expiry">Fecha de Caducidad</label>
                                <input wire:model="cardExpiry" class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-lg focus:ring-[#0FB593] focus:border-[#0FB593] sm:text-sm shadow-sm" id="card-expiry" placeholder="MM / AA" type="text"/>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center justify-between" for="card-cvc">
                                    CVV
                                    <span class="material-icons text-gray-400 text-base cursor-help" title="Código de 3 dígitos al reverso">help_outline</span>
                                </label>
                                <input wire:model="cardCvc" class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-lg focus:ring-[#0FB593] focus:border-[#0FB593] sm:text-sm shadow-sm" id="card-cvc" placeholder="123" type="text"/>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <input wire:model="saveCard" class="h-4 w-4 text-[#0FB593] focus:ring-[#0FB593] border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600" id="save-card" type="checkbox"/>
                            <label class="ml-2 block text-sm text-gray-900 dark:text-gray-300" for="save-card">
                                Guardar esta tarjeta para futuras compras de helado 🍦
                            </label>
                        </div>
                    </form>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <p>Procesamiento con {{ ucfirst($paymentMethod) }} implementado próximamente.</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-start">
                    <a class="flex items-center text-gray-500 dark:text-gray-400 hover:text-[#0FB593] dark:hover:text-[#0FB593] font-medium transition-colors" href="{{ route('checkout.delivery') }}" wire:navigate>
                        <span class="material-icons mr-1 text-sm">arrow_back_ios</span>
                        Volver a envíos
                    </a>
                </div>
            </div>

            <!-- Summary Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-24">
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white font-body">Resumen del Pedido</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @foreach($cartItems as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-lg flex-shrink-0 overflow-hidden">
                                <img alt="{{ $item['name'] }}" class="w-full h-full object-cover" src="{{ $item['image'] }}"/>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800 dark:text-gray-200">{{ $item['name'] }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::limit($item['description'], 30) }}</p>
                                <p class="text-[#0FB593] font-bold mt-1">${{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach

                        <hr class="border-gray-200 dark:border-gray-700 my-4"/>
                        <div class="space-y-2">
                            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                <span>Subtotal</span>
                                <span>${{ number_format($subtotal, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                <span>Envío</span>
                                <span class="text-green-500 font-medium">Gratis</span>
                            </div>
                        </div>
                        <hr class="border-gray-200 dark:border-gray-700 my-4"/>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-xl font-bold text-gray-900 dark:text-white">Total</span>
                            <span class="text-2xl font-bold text-[#0FB593]">${{ number_format($total, 2, ',', '.') }}</span>
                        </div>
                        <button wire:click="placeOrder" class="w-full bg-[#F92C85] hover:bg-pink-600 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center group">
                            Realizar Pedido
                            <span class="material-icons ml-2 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>
                        <div class="flex items-center justify-center mt-4 text-xs text-gray-400 dark:text-gray-500">
                            <span class="material-icons text-sm mr-1">lock</span>
                            Pago 100% Seguro y Encriptado
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-16 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 text-center border border-gray-100 dark:border-gray-700">
            <h3 class="text-2xl font-bold text-[#0FB593] mb-2 font-body">¿Necesitas ayuda con tu pedido?</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Nuestro equipo de soporte está disponible todos los días de 9am a 10pm.</p>
            <div class="flex justify-center gap-4 flex-wrap">
                <button class="flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-700 rounded-full text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors font-medium">
                    <span class="material-icons text-[#0FB593] mr-2">phone</span>
                    03482 42-8908
                </button>
                <button class="flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-700 rounded-full text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors font-medium">
                    <span class="material-icons text-[#F92C85] mr-2">email</span>
                    HeladoPolijub@gmail.com
                </button>
            </div>
        </div>
    </div>
    
    <x-footer />
</div>
