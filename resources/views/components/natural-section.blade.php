<!-- 3. Sección Inferior (100% NATURAL) -->
<div class="py-20 sm:py-24 relative overflow-hidden" style="background: linear-gradient(to bottom, #EBEBEB 0%, #f0f0f0 50%, #EBEBEB 100%);">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0 opacity-90">
        <img src="{{ asset('images/botella.webp') }}" alt="Botella de Leche" class="absolute top-1/2 left-1/2 w-1/2 max-w-lg -translate-x-1/4 -translate-y-1/2 -rotate-12 transform">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <!-- Columna 1: 100% NATURAL -->
            <div class="text-center md:text-left">
                <h2 class="text-5xl md:text-6xl font-bold uppercase text-emerald-500">
                    100% NATURAL
                </h2>
                <p class="mt-4 text-gray-600 text-lg">
                    Tenemos el orgullo de poder decir que nuestra materia prima principal, la leche, es de nuestra elaboración. Nadie mejor que nosotros para saber cómo crecen nuestras mejores socias.
                </p>
                <div class="mt-8">
                    <x-mary-button label="Descubrir más de 100%NAT" class="btn-primary bg-emerald-500 hover:bg-emerald-600 border-none text-white" link="#" />
                </div>
            </div>

            <!-- Columna 2: Producto Elaborado (Los Nenitos) -->
            <div class="w-full flex flex-col items-center lg:items-end text-center lg:text-right">
                <img src="{{ asset('images/LOS_NENITOS.webp') }}" alt="Los Nenitos Logo" class="w-30 h-auto mx-auto lg:mx-0 mb-4">
                 <div class="mt-8">
                    <a href="https://polijubweb.test/los-nenitos" class="inline-block bg-accent-blue hover:opacity-90 text-white uppercase font-semibold py-3 px-8 rounded-full transition-opacity duration-300">
                        Establecimiento LOS NÉÑITOS
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>