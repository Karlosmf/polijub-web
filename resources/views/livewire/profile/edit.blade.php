<div>
    <x-mary-header title="Mi Perfil" subtitle="Actualiza tus datos" separator />

    <div class="grid lg:grid-cols-2 gap-8">
        {{-- Info --}}
        <x-mary-card title="Información Personal" shadow>
            <x-mary-form wire:submit="updateProfile">
                <x-mary-input label="Nombre" wire:model="name" icon="o-user" />
                <x-mary-input label="Email" wire:model="email" icon="o-envelope" />
                
                <x-slot:actions>
                    <x-mary-button label="Guardar" class="btn-primary" type="submit" spinner="updateProfile" />
                </x-slot:actions>
            </x-mary-form>
        </x-mary-card>

        {{-- Password --}}
        <x-mary-card title="Seguridad" shadow>
            <x-mary-form wire:submit="updatePassword">
                <x-mary-input label="Nueva Contraseña" wire:model="password" type="password" icon="o-lock-closed" />
                <x-mary-input label="Confirmar Contraseña" wire:model="password_confirmation" type="password" icon="o-lock-closed" />
                
                <x-slot:actions>
                    <x-mary-button label="Cambiar Contraseña" class="btn-warning" type="submit" spinner="updatePassword" />
                </x-slot:actions>
            </x-mary-form>
        </x-mary-card>
    </div>
</div>
