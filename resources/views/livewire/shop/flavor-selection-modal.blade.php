<div
    x-data="{ open: @entangle('modalOpen') }"
    x-show="open"
    x-cloak
    class="relative z-50"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
    ></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            {{-- Modal Panel --}}
            <div
                x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl"
                @click.away="open = false"
            >
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-2xl font-semibold leading-6 text-gray-900 mb-2" id="modal-title">
                                Selecciona tus sabores
                            </h3>
                            <p class="text-sm text-gray-500 mb-6">
                                Estás agregando: <span class="font-bold text-brand-primary">{{ $productName }}</span> (x{{ $quantity }}).
                                <br>
                                Puedes elegir hasta <span class="font-bold">{{ $maxFlavors }}</span> sabores.
                                <span class="block mt-1 text-xs text-brand-secondary font-semibold">
                                    Seleccionados: {{ count($selectedFlavors) }} / {{ $maxFlavors }}
                                </span>
                            </p>

                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 max-h-[60vh] overflow-y-auto p-2">
                                @foreach($flavors as $flavor)
                                    @php
                                        $flavorImageUrl = '';
                                        if ($flavor->image) {
                                            $image = $flavor->image;
                                            if (str_starts_with($image, 'http')) {
                                                $flavorImageUrl = $image;
                                            } elseif (str_starts_with($image, 'images/') || str_starts_with($image, 'imgs/')) {
                                                $flavorImageUrl = '/' . $image;
                                            } elseif (!str_contains($image, '/')) {
                                                $flavorImageUrl = '/images/flavors/' . $image;
                                            } else {
                                                $flavorImageUrl = '/imgs/flavors/' . $image; // Fallback or specific case if needed
                                            }
                                        }
                                    @endphp
                                    <div 
                                        wire:click="toggleFlavor({{ $flavor->id }})"
                                        class="cursor-pointer relative rounded-lg border-2 p-3 flex flex-col items-center justify-center transition-all duration-200 group
                                        {{ in_array($flavor->id, $selectedFlavors) 
                                            ? 'border-brand-primary bg-brand-primary/5 ring-2 ring-brand-primary ring-opacity-50' 
                                            : (count($selectedFlavors) >= $maxFlavors ? 'border-gray-100 opacity-50 cursor-not-allowed' : 'border-gray-100 hover:border-brand-secondary hover:shadow-md') 
                                        }}"
                                    >
                                        @if($flavorImageUrl)
                                            <img src="{{ $flavorImageUrl }}" alt="{{ $flavor->name }}" class="w-16 h-16 object-cover rounded-full mb-2 shadow-sm">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 rounded-full mb-2 flex items-center justify-center text-gray-400">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        <span class="text-sm text-center font-medium leading-tight {{ in_array($flavor->id, $selectedFlavors) ? 'text-brand-primary' : 'text-gray-700' }}">
                                            {{ $flavor->name }}
                                        </span>
                                        
                                        @if(in_array($flavor->id, $selectedFlavors))
                                            <div class="absolute top-2 right-2 text-brand-primary">
                                                <svg class="w-5 h-5 bg-white rounded-full" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button
                        type="button"
                        wire:click="confirm"
                        class="inline-flex w-full justify-center rounded-md bg-brand-primary px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-secondary sm:ml-3 sm:w-auto disabled:opacity-50 disabled:cursor-not-allowed"
                        {{ count($selectedFlavors) === 0 && $maxFlavors > 0 ? 'disabled' : '' }}
                    >
                        Agregar al Carrito
                    </button>
                    <button
                        type="button"
                        wire:click="$set('modalOpen', false)"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                    >
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>