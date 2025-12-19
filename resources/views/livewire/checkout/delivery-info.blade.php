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

    public function mount()
    {
        $this->cartItems = session()->get('cart', []);

        if (empty($this->cartItems)) {
            $this->redirect(route('checkout.cart'), navigate: true);
            return;
        }

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

<div>
    <div class="flex-grow container mx-auto px-4 py-8 md:py-12">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-brand-primary mb-2 font-body">Proceso de Pago</h1>
            <x-checkout-steps step="2" />
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-2/3">
                <div class="rounded-xl shadow-sm p-6 md:p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-brand-primary/10 p-2 rounded-full">
                            <x-mary-icon class="w-6 h-6 text-brand-primary" name="phosphor.truck" />
                        </div>
                        <h2 class="text-xl font-bold font-body">Información de Envío</h2>
                    </div>

                    <form wire:submit="save" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-mary-input label="Correo Electrónico" wire:model="email" icon="phosphor.envelope"
                                placeholder="tu@email.com" type="email" />
                            <x-mary-input label="Teléfono" wire:model="phone" icon="phosphor.phone"
                                placeholder="(03482) 42-8908" type="tel" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-mary-input label="Nombre" wire:model="firstname" />
                            <x-mary-input label="Apellido" wire:model="lastname" />
                        </div>

                        <x-mary-input label="Dirección de Entrega" wire:model="address" icon="phosphor.map-pin"
                            placeholder="Calle Habegger y Obligado, 3560" />

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <x-mary-input label="Ciudad" wire:model="city" />
                            <x-mary-select label="Provincia" wire:model="province" :options="[
        ['id' => 'Santa Fe', 'name' => 'Santa Fe'],
        ['id' => 'Buenos Aires', 'name' => 'Buenos Aires'],
        ['id' => 'Córdoba', 'name' => 'Córdoba']
    ]" />
                            <x-mary-input label="Código Postal" wire:model="zip" />
                        </div>

                        <x-mary-textarea label="Notas de entrega (Opcional)" wire:model="notes"
                            placeholder="Ej: El timbre no funciona, llamar al llegar." rows="3" />

                        <div class="pt-4 flex items-center justify-between">
                            <x-mary-button label="Volver al carrito" link="{{ route('checkout.cart') }}"
                                icon="phosphor.arrow-left" class="btn-ghost text-gray-500" />
                            <x-mary-button type="submit" label="Continuar al Pago" icon-right="phosphor.arrow-right"
                                class="bg-brand-primary text-white shadow-lg" />
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Sidebar -->
            <div class="w-full lg:w-1/3">
                <x-order-summary :cartItems="$cartItems" :subtotal="$subtotal" :total="$total" :shipping="0"
                    :showItems="true" />
            </div>
        </div>
    </div>

    <x-footer />
</div>