<section>
    {{-- Parte Superior: Título --}}
    <div class="bg-white py-12 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800">aca va un titulo</h1>
    </div>

    {{-- Parte Inferior: Dos Columnas con imagen superpuesta --}}
    <div class="relative grid grid-cols-1 md:grid-cols-2 min-h-[50vh]">
        {{-- Columna Izquierda: Imagen Torta --}}
        <div class="bg-gray-200">
            <img src="{{ asset('torta.avif') }}" alt="Torta Helada Polijub" class="w-full h-full object-contain">
        </div>

        {{-- Columna Derecha: Contenido Centrado --}}
        <div class="bg-[#DCD7CA] flex flex-col items-center justify-center p-8 text-center">
            <div class="max-w-lg">
                <h2 class="text-4xl font-extrabold tracking-tight text-[#fe0196]">#LOQUEQUIERAS</h2>
                <p class="mt-4 text-base text-gray-600">
                    Para este #MESDELAMOR preparamos un montón de cosas ricas para disfrutar con todo el amor...,
                </p>
                <span class="mt-4 block text-2xl font-bold uppercase text-[#fe0196]">EL AMOR POR EL HELADO!!!</span>

                <a href="#" class="mt-8 inline-block bg-[#fe0196] text-white font-bold py-3 px-10 rounded-[5px] hover:bg-opacity-80 transition-all duration-300">
                    Ver más
                </a>
            </div>
        </div>

        {{-- Imagen Superpuesta --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/4 -translate-y-1/2 z-10 w-3/4 md:w-1/3">
             <img src="{{ asset('heroimg.gif') }}" alt="Hero Image" class="w-1/2 h-auto">
        </div>
    </div>
</section>
