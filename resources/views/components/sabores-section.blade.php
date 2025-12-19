<div class="bg-white">
    <!-- 1. Sección Superior (SABORES) -->
    <div class="relative min-h-screen bg-no-repeat bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('images/helados.webp') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center text-white text-center z-10">
            <h1 class="text-6xl md:text-8xl font-extrabold tracking-tight">SABORES...</h1>
            <p class="mt-4 max-w-2xl mx-auto text-gray-200 text-lg">
                Siempre es un buen momento para descubrir nuestros nuevos sabores. Probamos cosas ricas que nos gustan a todos y las convertimos en helado de la mejor calidad.
            </p>
            <div class="mt-8">
                <x-mary-button label="CONÓCELOS TODOS" class="btn-primary bg-cyan-500 hover:bg-cyan-600 border-none text-white" link="#" />
            </div>
        </div>
        <div class="absolute bottom-0 inset-x-0 z-0">
            <img src="{{ asset('images/milkupwhite.webp') }}" alt="Milk Up" class="w-full h-full object-cover opacity-50">
        </div>

        <!-- 2. Divisor de Onda -->
        <div class="absolute bottom-0 left-0 w-full h-[100px] text-white z-20" style="transform: translateY(1px);">
            <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 1440 100" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 100C240 30 480 100 720 100s480-70 720-70V100H0Z"/>
            </svg>
        </div>
    </div>

</div>