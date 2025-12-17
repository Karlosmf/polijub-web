<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.frontend')] class extends Component {
    public $email;
    public $phone;
    public $firstname;
    public $lastname;
    public $address;
    public $city = 'Reconquista';
    public $province = 'Santa Fe';
    public $zip;
    public $notes;
    
    public $subtotal = 0;
    public $shipping = 0;
    public $total = 0;
    public $cartItems = [];

    public function mount() {
        $this->cartItems = session()->get('cart', []);
        $this->subtotal = array_reduce($this->cartItems, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
        $this->total = $this->subtotal + $this->shipping;
    }

    public function save()
    {
        // Validation would go here
        session()->put('delivery_info', [
            'email' => $this->email,
            'phone' => $this->phone,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'zip' => $this->zip,
            'notes' => $this->notes,
        ]);
        $this->redirect(route('checkout.payment'), navigate: true);
    }
}; ?>

<div class="font-sans text-gray-900 bg-[#F7F9FB] dark:bg-gray-900 min-h-screen flex flex-col transition-colors duration-300">
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    
    <style>
        .font-body { font-family: 'Poppins', sans-serif; }
    </style>

    <div class="flex-grow container mx-auto px-4 py-8 md:py-12">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-[#1BC196] dark:text-[#1BC196] mb-2 font-body">Proceso de Pago</h1>
            <div class="flex justify-center items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                <span class="text-[#1BC196] font-semibold">Carrito</span>
                <span class="material-icons-outlined text-xs">chevron_right</span>
                <span class="text-[#1BC196] font-bold border-b-2 border-[#1BC196]">Envío</span>
                <span class="material-icons-outlined text-xs">chevron_right</span>
                <span>Pago</span>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-2/3">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-[#1BC196]/10 p-2 rounded-full">
                            <span class="material-icons-outlined text-[#1BC196]">local_shipping</span>
                        </div>
                        <h2 class="text-xl font-bold font-body text-gray-800 dark:text-white">Información de Envío</h2>
                    </div>
                    
                    <form wire:submit="save" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="email">Correo Electrónico</label>
                                <div class="relative">
                                    <span class="material-icons-outlined absolute left-3 top-2.5 text-gray-400">email</span>
                                    <input wire:model="email" class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-[#1BC196] focus:border-transparent dark:text-white transition shadow-sm" id="email" placeholder="tu@email.com" type="email"/>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="phone">Teléfono</label>
                                <div class="relative">
                                    <span class="material-icons-outlined absolute left-3 top-2.5 text-gray-400">phone</span>
                                    <input wire:model="phone" class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-[#1BC196] focus:border-transparent dark:text-white transition shadow-sm" id="phone" placeholder="(03482) 42-8908" type="tel"/>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="firstname">Nombre</label>
                                <input wire:model="firstname" class="w-full px-4 py-2 rounded-lg border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-[#1BC196] focus:border-transparent dark:text-white transition shadow-sm" id="firstname" type="text"/>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="lastname">Apellido</label>
                                <input wire:model="lastname" class="w-full px-4 py-2 rounded-lg border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-[#1BC196] focus:border-transparent dark:text-white transition shadow-sm" id="lastname" type="text"/>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="address">Dirección de Entrega</label>
                            <div class="relative">
                                <span class="material-icons-outlined absolute left-3 top-2.5 text-gray-400">location_on</span>
                                <input wire:model="address" class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-[#1BC196] focus:border-transparent dark:text-white transition shadow-sm" id="address" placeholder="Calle Habegger y Obligado, 3560" type="text"/>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="city">Ciudad</label>
                                <input wire:model="city" class="w-full px-4 py-2 rounded-lg border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-[#1BC196] focus:border-transparent dark:text-white transition shadow-sm" id="city" type="text"/>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="province">Provincia</label>
                                <select wire:model="province" class="w-full px-4 py-2 rounded-lg border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-[#1BC196] focus:border-transparent dark:text-white transition shadow-sm" id="province">
                                    <option>Santa Fe</option>
                                    <option>Buenos Aires</option>
                                    <option>Córdoba</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="zip">Código Postal</label>
                                <input wire:model="zip" class="w-full px-4 py-2 rounded-lg border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-[#1BC196] focus:border-transparent dark:text-white transition shadow-sm" id="zip" type="text"/>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="notes">Notas de entrega (Opcional)</label>
                            <textarea wire:model="notes" class="w-full px-4 py-2 rounded-lg border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-[#1BC196] focus:border-transparent dark:text-white transition shadow-sm" id="notes" placeholder="Ej: El timbre no funciona, llamar al llegar." rows="3"></textarea>
                        </div>

                        <div class="pt-4 flex items-center justify-between">
                            <a class="text-sm text-gray-500 dark:text-gray-400 hover:text-[#1BC196] flex items-center" href="{{ route('checkout.cart') }}" wire:navigate>
                                <span class="material-icons-outlined text-sm mr-1">arrow_back</span>
                                Volver al carrito
                            </a>
                            <button type="submit" class="bg-[#1BC196] hover:bg-emerald-500 text-white font-semibold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                                Continuar al Pago
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sticky top-24">
                    <h3 class="text-lg font-bold mb-4 border-b border-gray-100 dark:border-gray-700 pb-3 font-body text-gray-800 dark:text-white">Resumen del Pedido</h3>
                    
                    <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cartItems as $item)
                        <div class="flex items-center gap-3">
                            <div class="h-16 w-16 bg-blue-100 rounded-md overflow-hidden flex-shrink-0">
                                <img alt="{{ $item['name'] }}" class="h-full w-full object-cover" src="{{ $item['image'] }}"/>
                            </div>
                            <div class="flex-grow">
                                <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $item['name'] }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::limit($item['description'], 30) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-800 dark:text-gray-200">${{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-2 text-sm border-t border-gray-100 dark:border-gray-700 pt-4">
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Envío</span>
                            <span class="text-[#1BC196] font-medium">Gratis</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <span class="text-base font-bold text-gray-800 dark:text-white">Total</span>
                        <span class="text-2xl font-bold text-[#1BC196]">${{ number_format($total, 2, ',', '.') }}</span>
                    </div>

                    <div class="mt-6">
                        <div class="flex gap-2">
                            <input class="flex-grow px-3 py-2 text-sm rounded-lg border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-1 focus:ring-[#1BC196] focus:border-[#1BC196] transition dark:text-white" placeholder="Código de descuento" type="text"/>
                            <button class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-500 transition">
                                Aplicar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <x-footer />
</div>
