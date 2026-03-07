<div>
    <x-header title="Gestión de Usuarios" subtitle="Administra los usuarios del sistema" separator>
        <x-slot:actions>
            <x-button label="Nuevo Usuario" icon="o-plus" class="btn-primary" wire:click="create" />
        </x-slot:actions>
    </x-header>

    @php
        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'w-16'],
            ['key' => 'name', 'label' => 'Nombre'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'role_label', 'label' => 'Rol'],
            ['key' => 'actions', 'label' => 'Acciones', 'class' => 'text-right']
        ];
    @endphp
    @php
        $userRows = $users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_label' => $user->role->label(),
                'actions' => ''
            ];
        });
    @endphp

    <x-table :headers="$headers" :rows="$userRows">
        @scope('cell_role_label', $user)
            <x-badge :value="$user['role_label']" class="badge-outline" />
        @endscope
        
        @scope('cell_actions', $user)
            <div class="flex justify-end gap-2">
                <x-button icon="o-pencil" wire:click="edit({{ $user['id'] }})" class="btn-sm btn-ghost text-primary" spinner />
                @if($user['id'] !== auth()->id())
                    <x-button icon="o-trash" wire:click="delete({{ $user['id'] }})" class="btn-sm btn-ghost text-error" 
                        wire:confirm="¿Estás seguro de eliminar este usuario?" spinner />
                @endif
            </div>
        @endscope
    </x-table>

    <x-modal wire:model="userModal" :title="$isEditing ? 'Editar Usuario' : 'Crear Usuario'" separator>
        <div class="grid gap-4">
            <x-input label="Nombre" wire:model="name" icon="o-user" />
            <x-input label="Email" wire:model="email" icon="o-envelope" />
            
            <x-select label="Rol" :options="$roles" wire:model="role" icon="o-shield-check" />

            <x-input label="Contraseña" wire:model="password" type="password" icon="o-key" 
                :placeholder="$isEditing ? 'Dejar en blanco para mantener actual' : 'Mínimo 6 caracteres'" />
        </div>

        <x-slot:actions>
            <x-button label="Cancelar" wire:click="userModal = false" />
            <x-button label="Guardar" class="btn-primary" wire:click="save" spinner="save" />
        </x-slot:actions>
    </x-modal>
</div>
