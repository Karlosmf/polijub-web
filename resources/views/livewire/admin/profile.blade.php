<div>
    <x-header title="Mi Perfil" subtitle="Actualiza tus datos personales y seguridad" separator />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Profile Information --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Información del Perfil</h2>
                
                <form wire:submit="updateProfile" class="space-y-4 mt-4">
                    <x-input label="Nombre" wire:model="name" icon="o-user" />
                    <x-input label="Correo Electrónico" wire:model="email" icon="o-envelope" />
                    
                    <div class="card-actions justify-end mt-4">
                        <x-button label="Guardar Cambios" class="btn-primary" type="submit" spinner="updateProfile" />
                    </div>
                </form>
            </div>
        </div>

        {{-- Update Password --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Actualizar Contraseña</h2>
                
                <form wire:submit="updatePassword" class="space-y-4 mt-4">
                    <x-input label="Nueva Contraseña" wire:model="password" type="password" icon="o-lock-closed" />
                    <x-input label="Confirmar Contraseña" wire:model="password_confirmation" type="password" icon="o-lock-closed" />
                    
                    <div class="card-actions justify-end mt-4">
                        <x-button label="Cambiar Contraseña" class="btn-warning" type="submit" spinner="updatePassword" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
