<div>
    <x-header title="Dashboard" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-button icon="o-arrow-path" class="btn-ghost btn-sm" wire:click="$refresh" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Generar Reporte" icon="o-document-chart-bar" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <x-stat title="Ventas Totales" value="${{ number_format($totalRevenue, 2) }}" icon="o-currency-dollar"
            class="bg-green-700" />
        <x-stat title="Pedidos Pendientes" value="{{ $pendingOrders }}" icon="o-shopping-bag" class="bg-orange-700" />
        <x-stat title="Usuarios" value="{{ $usersCount }}" icon="o-users" class="bg-blue-700" />
        <x-stat title="Productos Activos" value="{{ $productsCount }}" icon="o-cube" class="bg-purple-700" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Recent Orders --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-0">
                <div class="p-4 border-b border-base-200 flex justify-between items-center">
                    <h3 class="font-bold text-lg">Pedidos Recientes</h3>
                    <x-button label="Ver Todo" link="#" class="btn-ghost btn-xs" />
                </div>

                @if($recentOrders->count() > 0)
                            <x-table :headers="[
                        ['key' => 'id', 'label' => '#'],
                        ['key' => 'user.name', 'label' => 'Cliente'],
                        ['key' => 'total', 'label' => 'Total'],
                        ['key' => 'status', 'label' => 'Estado'],
                        ['key' => 'created_at', 'label' => 'Fecha']
                    ]" :rows="$recentOrders" striped>
                                @scope('cell_total', $order)
                                ${{ number_format($order->total, 2) }}
                                @endscope
                                @scope('cell_status', $order)
                                @if($order->status == 'pending')
                                    <x-badge value="Pendiente" class="badge-warning" />
                                @elseif($order->status == 'completed')
                                    <x-badge value="Completado" class="badge-success" />
                                @else
                                    <x-badge :value="$order->status" class="badge-ghost" />
                                @endif
                                @endscope
                                @scope('cell_created_at', $order)
                                {{ $order->created_at->format('d/m H:i') }}
                                @endscope
                            </x-table>
                @else
                    <div class="p-10 text-center text-gray-500">
                        <x-icon name="o-inbox" class="w-12 h-12 mx-auto opacity-50 mb-2" />
                        <p>No hay pedidos recientes.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions & System Status --}}
        <div class="space-y-6">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title text-base mb-4">Acciones Rápidas</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <x-button icon="o-cube" label="Nuevo Producto"
                            link="{{ route('admin.products', ['create' => true]) }}" class="btn-outline" />
                        <x-button icon="o-beaker" label="Nuevo Sabor"
                            link="{{ route('admin.flavors', ['create' => true]) }}" class="btn-outline" />
                        <x-button icon="o-tag" label="Nueva Etiqueta"
                            link="{{ route('admin.tags', ['create' => true]) }}" class="btn-outline" />
                        <x-button icon="o-users" label="Usuarios" class="btn-outline" disabled />
                    </div>
                </div>
            </div>

            <div class="card bg-primary text-primary-content shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Polijub Admin</h2>
                    <p>Bienvenido al panel de administración. Revisa las estadísticas y gestiona tu catálogo fácilmente.
                    </p>
                    <div class="card-actions justify-end">
                        <x-button label="Ir a la Tienda" link="/" class="btn-secondary" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>