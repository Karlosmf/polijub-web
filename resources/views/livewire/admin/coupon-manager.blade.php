<div>
    <x-mary-header title="Gestión de Cupones" subtitle="Administra tus códigos promocionales y descuentos" separator>
        <x-slot:actions>
            <x-mary-button label="Nuevo Cupón" icon="o-plus" class="btn-primary" wire:click="create" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-card>
        <table class="table w-full">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Beneficio</th>
                    <th>Restricciones</th>
                    <th>Usos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coupons as $coupon)
                <tr>
                    <td class="font-bold">{{ $coupon->code }}</td>
                    <td>
                        @php
                            $badgeLabel = match($coupon->type) {
                                'percentage' => 'Porcentaje',
                                'fixed_product' => 'Producto Gratis',
                                'fixed_amount' => 'Importe Fijo',
                            };
                            $badgeClass = match($coupon->type) {
                                'percentage' => 'badge-info',
                                'fixed_product' => 'badge-success',
                                'fixed_amount' => 'badge-warning',
                            };
                        @endphp
                        <x-mary-badge :label="$badgeLabel" :class="$badgeClass" />
                    </td>
                    <td>
                        @if($coupon->type === 'percentage')
                            {{ $coupon->value }}%
                        @elseif($coupon->type === 'fixed_amount')
                            ${{ number_format($coupon->value, 2, ',', '.') }}
                        @else
                            {{ $coupon->product->name ?? 'N/A' }}
                        @endif
                    </td>
                    <td class="text-xs">
                        @if($coupon->user_id)
                            <div class="text-info">Exclusivo: {{ $coupon->user->name }}</div>
                        @endif
                        @if($coupon->expires_at)
                            <div class="{{ $coupon->expires_at->isPast() ? 'text-error' : '' }}">
                                Expira: {{ $coupon->expires_at->format('d/m/Y H:i') }}
                            </div>
                        @endif
                        @if(!$coupon->user_id && !$coupon->expires_at)
                            <span class="text-gray-400">Ninguna</span>
                        @endif
                    </td>
                    <td>
                        {{ $coupon->uses_count }} / {{ $coupon->max_uses ?? '∞' }}
                    </td>
                    <td>
                        <x-mary-button :icon="$coupon->is_active ? 'o-check-circle' : 'o-x-circle'" 
                            :class="$coupon->is_active ? 'btn-ghost text-success' : 'btn-ghost text-error'"
                            wire:click="toggleActive({{ $coupon->id }})" />
                    </td>
                    <td>
                        <div class="flex gap-2">
                            <x-mary-button icon="o-pencil" class="btn-sm btn-ghost" wire:click="edit({{ $coupon->id }})" />
                            <x-mary-button icon="o-trash" class="btn-sm btn-ghost text-error" 
                                wire:confirm="¿Estás seguro de eliminar este cupón?"
                                wire:click="delete({{ $coupon->id }})" />
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </x-mary-card>

    <x-mary-modal wire:model="myModal" :title="$isEditing ? 'Editar Cupón' : 'Nuevo Cupón'" separator>
        <x-mary-form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <x-mary-input label="Código" wire:model="code" placeholder="Ej: VERANO2026" />
                    <x-mary-button label="Generar código aleatorio" class="btn-xs btn-ghost mt-1" wire:click="generateCode" />
                </div>

                <x-mary-select label="Tipo de Beneficio" wire:model.live="type" spinner :options="[
                    ['id' => 'percentage', 'name' => 'Porcentaje de descuento'],
                    ['id' => 'fixed_amount', 'name' => 'Importe fijo de descuento'],
                    ['id' => 'fixed_product', 'name' => 'Canje por producto gratis']
                ]" />

                <div class="relative min-h-[80px] flex items-end">
                    <div wire:loading wire:target="type" class="absolute inset-0 flex items-center justify-center bg-base-100/50 z-10 rounded-lg">
                        <x-mary-loading class="text-brand-primary" />
                    </div>

                    <div class="w-full" wire:loading.remove wire:target="type">
                        @if($type === 'percentage')
                            <x-mary-input label="Porcentaje (%)" wire:model="value" type="number" suffix="%" />
                        @elseif($type === 'fixed_amount')
                            <x-mary-input label="Importe ($)" wire:model="value" type="number" prefix="$" />
                        @else
                            <x-mary-select label="Producto" wire:model="product_id" :options="$products" />
                        @endif
                    </div>
                </div>

                <x-mary-select label="Usuario Específico (Opcional)" wire:model="user_id" :options="$users" placeholder="Cualquier usuario" />
                
                <x-mary-input label="Máximo de usos" wire:model="max_uses" type="number" placeholder="Sin límite" />
                
                <x-mary-input label="Fecha de inicio" wire:model="starts_at" type="datetime-local" />
                <x-mary-input label="Fecha de expiración" wire:model="expires_at" type="datetime-local" />

                <div class="md:col-span-2">
                    <x-mary-checkbox label="¿Está activo?" wire:model="is_active" />
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="Cancelar" @click="$wire.myModal = false" />
                <x-mary-button label="Guardar" type="submit" class="btn-primary" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>
