<?php

use Livewire\Volt\Component;
use App\Models\Order;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component {
    use WithPagination;

    public function with(): array
    {
        return [
            'orders' => Order::with('user', 'items')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ];
    }
}; ?>

<div>
    <x-header title="Pedidos" subtitle="Gestión de órdenes de compra" separator progress-indicator />

    <x-table :headers="[
        ['key' => 'id', 'label' => '#'],
        ['key' => 'guest_name', 'label' => 'Cliente'],
        ['key' => 'total', 'label' => 'Total'],
        ['key' => 'status', 'label' => 'Estado'],
        ['key' => 'created_at', 'label' => 'Fecha'],
        ['key' => 'payment_method', 'label' => 'Pago'],
    ]" :rows="$orders" :link="route('admin.orders.show', ['order' => '[id]'])" striped>
        @scope('cell_guest_name', $order)
            @if($order->user)
                {{ $order->user->name }}
            @else
                {{ $order->guest_name }} {{ $order->guest_lastname }}
                <div class="text-xs text-gray-500">{{ $order->guest_email }}</div>
            @endif
        @endscope

        @scope('cell_total', $order)
            ${{ number_format($order->total, 2) }}
        @endscope

        @scope('cell_status', $order)
            <x-badge :value="$order->status" class="badge-info" />
        @endscope

        @scope('cell_created_at', $order)
            {{ $order->created_at->format('d/m/Y H:i') }}
        @endscope
    </x-table>

    {{ $orders->links() }}
</div>
