<?php

use Livewire\Volt\Component;
use App\Models\Order;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component {
    public Order $order;

    public function mount(Order $order)
    {
        $this->order = $order->load('items', 'user');
    }
}; ?>

<div>
    <x-header title="Detalle del Pedido #{{ $order->id }}" separator>
        <x-slot:actions>
            <x-button label="Volver" icon="o-arrow-left" link="{{ route('admin.orders') }}" />
        </x-slot:actions>
    </x-header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Order Info --}}
        <x-card title="Información del Pedido">
            <div class="space-y-2">
                <div><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</div>
                <div><strong>Estado:</strong> <x-badge :value="$order->status" class="badge-info" /></div>
                <div><strong>Total:</strong> ${{ number_format($order->total, 2) }}</div>
                <div><strong>Método de Pago:</strong> {{ ucfirst($order->payment_method) }}</div>
            </div>
        </x-card>

        {{-- Customer Info --}}
        <x-card title="Información del Cliente">
            <div class="space-y-2">
                @if($order->user)
                    <div><strong>Usuario:</strong> {{ $order->user->name }}</div>
                    <div><strong>Email:</strong> {{ $order->user->email }}</div>
                @else
                    <div><strong>Nombre:</strong> {{ $order->guest_name }} {{ $order->guest_lastname }}</div>
                    <div><strong>Email:</strong> {{ $order->guest_email }}</div>
                    <div><strong>Teléfono:</strong> {{ $order->guest_phone }}</div>
                @endif
                <hr class="my-2">
                <div><strong>Dirección:</strong> {{ $order->address }}</div>
                <div><strong>Ciudad:</strong> {{ $order->city }}, {{ $order->province }}</div>
                <div><strong>CP:</strong> {{ $order->zip }}</div>
                @if($order->notes)
                    <div class="mt-2 text-sm text-gray-500"><strong>Notas:</strong> {{ $order->notes }}</div>
                @endif
            </div>
        </x-card>
    </div>

    {{-- Order Items --}}
    <x-card title="Productos" class="mt-6">
        <x-table :headers="[
            ['key' => 'name', 'label' => 'Producto'],
            ['key' => 'price', 'label' => 'Precio Unitario'],
            ['key' => 'quantity', 'label' => 'Cantidad'],
            ['key' => 'total', 'label' => 'Total'],
        ]" :rows="$order->items">
            @scope('cell_price', $item)
                ${{ number_format($item->price, 2) }}
            @endscope
            @scope('cell_total', $item)
                ${{ number_format($item->price * $item->quantity, 2) }}
            @endscope
        </x-table>
    </x-card>
</div>
