<div>
    <x-mary-header title="Theme Selection" subtitle="Preview themes with MaryUI widgets" separator>
        <x-slot:actions>
             <div class="flex items-center gap-2 flex-wrap justify-end">
                @foreach($themes as $theme)
                    <button 
                        class="btn btn-sm"
                        :class="theme == '{{ $theme }}' ? 'btn-primary' : ''"
                        x-on:click="updateTheme('{{ $theme }}')"
                    >
                        {{ ucfirst($theme) }}
                    </button>
                @endforeach
             </div>
        </x-slot:actions>
    </x-mary-header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-mary-stat 
            title="Ventas Totales" 
            value="$12,450" 
            icon="o-currency-dollar" 
            description="32% más que el mes pasado" 
            color="text-primary" />
        
        <x-mary-stat 
            title="Nuevos Clientes" 
            value="45" 
            icon="o-users" 
            description="Esta semana" 
            color="text-secondary" />

        <x-mary-stat 
            title="Pedidos Pendientes" 
            value="12" 
            icon="o-shopping-bag" 
            description="Requieren atención" 
            color="text-error" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Card with Form elements --}}
        <x-mary-card title="Elementos de Formulario" subtitle="Prueba los inputs y botones" separator shadow>
            <div class="space-y-4">
                <x-mary-input label="Nombre de Usuario" placeholder="Ingresa tu nombre" icon="o-user" />
                <x-mary-select label="Rol del Usuario" :options="[['id'=>1,'name'=>'Admin'],['id'=>2,'name'=>'Editor']]" />
                <x-mary-toggle label="Notificaciones activas" />
                
                <div class="flex gap-2 justify-end mt-4">
                    <x-mary-button label="Cancelar" />
                    <x-mary-button label="Guardar" variant="primary" icon="o-check" />
                </div>
            </div>
        </x-mary-card>

        {{-- Table preview --}}
        <x-mary-card title="Listado de Usuarios" subtitle="Vista de tabla" separator shadow>
            <x-mary-table :rows="$users" :headers="[['key'=>'name','label'=>'Nombre'],['key'=>'role','label'=>'Rol']]" striped />
        </x-mary-card>
    </div>

    <div class="mt-8 flex gap-4 flex-wrap">
        <x-mary-badge value="Principal" class="badge-primary" />
        <x-mary-badge value="Secundario" class="badge-secondary" />
        <x-mary-badge value="Acento" class="badge-accent" />
        <x-mary-badge value="Info" class="badge-info" />
        <x-mary-badge value="Éxito" class="badge-success" />
        <x-mary-badge value="Advertencia" class="badge-warning" />
        <x-mary-badge value="Error" class="badge-error" />
    </div>
</div>
