@props(['step' => 1])

<div class="w-full max-w-3xl mx-auto mb-10">
    <!-- Mobile / Compact View (Just Text + Icons) -->
    <div class="flex md:hidden justify-between items-center px-4">
        <div class="flex flex-col items-center {{ $step >= 1 ? 'text-brand-primary' : 'text-base-content/30' }}">
            <div class="p-2 rounded-full {{ $step >= 1 ? 'bg-brand-primary/10' : 'bg-base-200' }}">
                <x-mary-icon name="phosphor.shopping-cart" class="w-5 h-5" />
            </div>
            <span class="text-[10px] font-bold mt-1">Carrito</span>
        </div>
        
        <div class="h-0.5 w-10 {{ $step >= 2 ? 'bg-brand-primary' : 'bg-base-200' }}"></div>
        
        <div class="flex flex-col items-center {{ $step >= 2 ? 'text-brand-primary' : 'text-base-content/30' }}">
            <div class="p-2 rounded-full {{ $step >= 2 ? 'bg-brand-primary/10' : 'bg-base-200' }}">
                <x-mary-icon name="phosphor.truck" class="w-5 h-5" />
            </div>
            <span class="text-[10px] font-bold mt-1">Envío</span>
        </div>

        <div class="h-0.5 w-10 {{ $step >= 3 ? 'bg-brand-primary' : 'bg-base-200' }}"></div>

        <div class="flex flex-col items-center {{ $step >= 3 ? 'text-brand-primary' : 'text-base-content/30' }}">
             <div class="p-2 rounded-full {{ $step >= 3 ? 'bg-brand-primary/10' : 'bg-base-200' }}">
                <x-mary-icon name="phosphor.credit-card" class="w-5 h-5" />
            </div>
            <span class="text-[10px] font-bold mt-1">Pago</span>
        </div>
    </div>

    <!-- Desktop / Full View (DaisyUI Steps with Custom Content) -->
    <ul class="steps w-full hidden md:grid">
        <!-- Step 1: Carrito -->
        <li data-content="" class="step relative {{ $step >= 1 ? 'before:!bg-brand-primary after:!bg-brand-primary after:!text-white text-brand-primary' : 'text-base-content/40 after:!bg-base-200' }}">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 translate-y-1.5 z-20">
                <x-mary-icon name="phosphor.shopping-cart" class="w-5 h-5 {{ $step >= 1 ? 'text-white' : 'text-base-content/40' }}" />
            </div>
            <span class="mt-2 uppercase tracking-wider font-bold text-xs">Carrito</span>
        </li>

        <!-- Step 2: Envío -->
        <li data-content="" class="step relative {{ $step >= 2 ? 'before:!bg-brand-primary after:!bg-brand-primary after:!text-white text-brand-primary' : 'text-base-content/40 after:!bg-base-200' }}">
             <div class="absolute top-0 left-1/2 -translate-x-1/2 translate-y-1.5 z-20">
                <x-mary-icon name="phosphor.truck" class="w-5 h-5 {{ $step >= 2 ? 'text-white' : 'text-base-content/40' }}" />
            </div>
            <span class="mt-2 uppercase tracking-wider font-bold text-xs">Envío</span>
        </li>

        <!-- Step 3: Pago -->
        <li data-content="" class="step relative {{ $step >= 3 ? 'before:!bg-brand-primary after:!bg-brand-primary after:!text-white text-brand-primary' : 'text-base-content/40 after:!bg-base-200' }}">
             <div class="absolute top-0 left-1/2 -translate-x-1/2 translate-y-1.5 z-20">
                <x-mary-icon name="phosphor.credit-card" class="w-5 h-5 {{ $step >= 3 ? 'text-white' : 'text-base-content/40' }}" />
            </div>
            <span class="mt-2 uppercase tracking-wider font-bold text-xs">Pago</span>
        </li>
    </ul>
</div>
