<div>
    <x-mary-header title="Mi Perfil" subtitle="Actualiza tus datos personales y seguridad" separator />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Loyalty Points --}}
        <div class="card bg-secondary text-secondary-content shadow-xl">
            <div class="card-body flex-row items-center gap-6">
                <x-mary-icon name="o-star" class="w-16 h-16" />
                <div>
                    <h2 class="card-title text-xl opacity-80">Puntos Acumulados</h2>
                    <div class="text-5xl font-black">{{ $points }}</div>
                    <p class="text-sm mt-2 opacity-70">¡Canjea tus puntos por descuentos!</p>
                </div>
            </div>
        </div>

        {{-- Referral System --}}
        <div class="card bg-primary text-primary-content shadow-xl">
            <div class="card-body">
                <div class="flex items-center gap-4">
                    <x-mary-icon name="o-gift" class="w-10 h-10" />
                    <div>
                        <h2 class="card-title text-lg font-bold">Sistema de Referidos</h2>
                        <p class="text-sm opacity-90">Gana cupones compartiendo tu código.</p>
                    </div>
                </div>
                
                <div class="mt-4 bg-base-100/20 p-3 rounded-lg flex items-center justify-between">
                    <div class="font-mono font-bold text-xl tracking-widest">{{ $referral_code }}</div>
                    <div class="flex gap-2">
                        <x-mary-button 
                            icon="o-clipboard" 
                            class="btn-xs btn-ghost bg-base-100/30"
                            onclick="navigator.clipboard.writeText('{{ $referral_code }}'); alert('¡Código copiado!');"
                            tooltip="Copiar"
                        />
                        @php
                            $shareText = "¡Hola! Regístrate en Polijub usando mi código $referral_code y obtén un descuento en tu primera compra: " . route('register');
                            $whatsappUrl = "https://wa.me/?text=" . urlencode($shareText);
                        @endphp
                        <x-mary-button 
                            icon="o-chat-bubble-left-right" 
                            class="btn-xs btn-accent"
                            link="{{ $whatsappUrl }}"
                            external
                            tooltip="WhatsApp"
                        />
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Information --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Información del Perfil</h2>
                
                <form wire:submit="updateProfile" class="space-y-4 mt-4">
                    <x-mary-input label="Nombre" wire:model="name" icon="o-user" />
                    <x-mary-input label="Correo Electrónico" wire:model="email" icon="o-envelope" />
                    
                    <div class="card-actions justify-end mt-4">
                        <x-mary-button label="Guardar Cambios" class="btn-primary" type="submit" spinner="updateProfile" />
                    </div>
                </form>
            </div>
        </div>

        {{-- Update Password --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Actualizar Contraseña</h2>
                
                <form wire:submit="updatePassword" class="space-y-4 mt-4">
                    <x-mary-input label="Nueva Contraseña" wire:model="password" type="password" icon="o-lock-closed" />
                    <x-mary-input label="Confirmar Contraseña" wire:model="password_confirmation" type="password" icon="o-lock-closed" />
                    
                    <div class="card-actions justify-end mt-4">
                        <x-mary-button label="Cambiar Contraseña" class="btn-warning" type="submit" spinner="updatePassword" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
