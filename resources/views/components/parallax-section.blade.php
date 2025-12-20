<!-- Parallax Section -->
<div class="relative min-h-[70vh] bg-no-repeat bg-cover bg-center bg-fixed"
    style="background-image: url('{{ asset('images/potehelado.webp') }}');">
    <!-- Top Decorative Image: Milk Down -->
    <img src="{{ asset('images/milkdown.webp') }}" alt="Milk Down" class="absolute top-0 left-0 w-full z-0">

    <div
        class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 flex flex-col items-center justify-center text-center">
        <!-- 1. Título y Párrafos de Introducción -->
        <div class="text-left text-white mb-16 mt-32">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight uppercase">
                DELIVERY:
            </h1>
            <p class="mt-6 max-w-3xl text-lg md:text-xl">
                En el centro de Reconquista, Av. Habegger y Obligado tenemos la central de pedidos. Podés llamarnos por
                teléfono, escribirnos por Whatsapp, hacer tu pedido desde la Web, o la App.... y siempre, pero siempre
                recibís toda la calidad de Polijub.
            </p>
            <p class="mt-4 max-w-3xl text-xl md:text-2xl font-semibold">
                En tres pasos estás comiendo helado.
            </p>
        </div>
        <!-- 2. Caja de Pasos -->
        <div class="relative bg-white rounded-[2rem] shadow-2xl p-8 md:p-12 -mt-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 text-center">
                <!-- Paso 01 -->
                <div class="flex flex-col items-center">
                    <span class="text-6xl font-extrabold text-gray-700 leading-none">01</span>

                    <img src="{{ asset('images/lupa.avif') }}" alt="Icono de Lupa" class="w-32 h-32 object-contain">
                    <p class="text-gray-600 font-medium">Hacés el pedido como prefieras</p>
                </div>

                <!-- Paso 02 -->
                <div class="flex flex-col items-center">
                    <span class="text-6xl font-extrabold text-gray-700 leading-none">02</span>

                    <img src="{{ asset('images/pagar.avif') }}" alt="Icono de Pagar" class="w-32 h-32 object-contain">
                    <p class="text-gray-600 font-medium">Lo abonás como vos quieras</p>
                </div>

                <!-- Paso 03 -->
                <div class="flex flex-col items-center">
                    <span class="text-6xl font-extrabold text-gray-700 leading-none">03</span>

                    <img src="{{ asset('images/corazon.avif') }}" alt="Icono de Corazón"
                        class="w-32 h-32 object-contain">
                    <p class="text-gray-600 font-medium">Atendé la puerta y disfrutá</p>
                </div>
            </div>

            <!-- 4. Botón de Acción Principal -->
            <div class="text-center mt-12">
                <a href="{{ route('shop.products') }}"
                    class="inline-block bg-emerald-500 hover:bg-emerald-600 text-white uppercase font-bold py-4 px-10 rounded-full shadow-lg transform hover:scale-105 transition-transform duration-300 -mb-16">
                    Hacé tu pedido YA mismo!
                </a>
            </div>
        </div>

        <!-- 5. Bloque de Enlace Final -->
        <div class="text-left text-white mt-12">
            <p class="mt-6 max-w-3xl text-lg md:text-xl">
                A continuación, datos de cada contacto de cada una de las sucursales Polijub...
            </p>
            <div class="mt-6">
                <a href="#"
                    class="inline-block bg-white text-sky-500 hover:bg-gray-100 uppercase font-bold py-3 px-8 rounded-full shadow-md transition-colors duration-300">
                    Sucursales y teléfonos de Delivery
                </a>
            </div>
        </div>
    </div>
</div>