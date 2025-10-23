<div>
    <section id="sabores" class="bg-gray-50 pb-16">
        
        {{-- Bloque Superior: Contenido de Texto --}}
        <div class="max-w-7xl mx-auto pt-16 px-6 lg:px-8 relative z-10 mb-[-10rem] md:mb-[-12rem]">
            <div class="bg-white shadow-2xl rounded-lg p-8 md:p-12">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-center">
                    
                    <div class="text-left">
                        <h2 class="text-6xl lg:text-7xl font-thin tracking-wider text-[#DCD7CA]">SABORES...</h2>
                        <p class="mt-4 font-light text-gray-700 leading-relaxed">
                            Siempre es un buen momento para descubrir nuestros nuevos sabores, porque al igual que siempre, probamos cosas ricas que nos gustan a todos, y las convertimos en helado de la mejor calidad... Calidad Polijub.
                        </p>
                    </div>

                    <div class="flex justify-start mt-8 md:mt-0">
                        <a href="#" {{-- Debería ser: {{ route('sabores') }} --}}
                           class="inline-block bg-brand-primary text-white uppercase font-bold tracking-widest py-4 px-10 rounded-md shadow-lg hover:bg-opacity-90 transition-transform hover:scale-105">
                            Conocelos todos
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- Bloque Inferior: Imagen de Bochas --}}
        <div class="w-full h-[60vh]">
            <img src="{{ asset('sabores.avif') }}" alt="Bochas de helado" class="w-full h-full object-cover">
        </div>

    </section>
</div>