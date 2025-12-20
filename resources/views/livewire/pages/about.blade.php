<div>
    {{-- Hero Section --}}
    <div class="relative h-[450px] w-full flex items-center justify-center overflow-hidden">
        <img src="{{ asset('storage/imgs/background.webp') }}" alt="Polijub Background" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-5xl md:text-7xl font-bold font-display uppercase tracking-tighter mb-4">Sobre Nosotros</h1>
            <div class="h-1.5 w-24 bg-brand-primary mx-auto rounded-full mb-6"></div>
            <p class="text-xl md:text-2xl font-light max-w-2xl mx-auto italic opacity-90">"Más de 40 años endulzando momentos en el noreste santafesino."</p>
        </div>
    </div>

    {{-- Content Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            
            {{-- Main Text --}}
            <div class="lg:col-span-7">
                <div class="prose prose-lg max-w-none text-base-content/80">
                    <h2 class="text-3xl font-bold text-brand-primary mb-6 font-display">Nuestra Historia</h2>
                    <p class="leading-relaxed mb-6">
                        <span class="font-bold text-brand-secondary text-xl">Polijub</span> es una reconocida cadena de heladerías artesanales con más de <span class="font-semibold text-brand-primary italic">40 años de trayectoria</span> en la región del noreste de Santa Fe, Argentina.
                    </p>
                    <p class="mb-8">
                        Desde nuestros inicios, nos hemos comprometido con la excelencia, llevando a cada mesa el sabor auténtico de lo artesanal y la frescura de nuestra tierra.
                    </p>

                    <div class="bg-base-200/50 p-8 rounded-3xl border border-base-300 mb-8 shadow-sm">
                        <h3 class="text-2xl font-bold text-brand-primary font-display mb-6 flex items-center gap-2">
                            <x-mary-icon name="phosphor.star-fill" class="w-6 h-6 text-brand-secondary" />
                            Características Principales (2025)
                        </h3>
                        
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div class="bg-brand-primary text-white p-2 rounded-xl h-fit shadow-md">
                                    <x-mary-icon name="phosphor.leaf" class="w-6 h-6" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-brand-secondary uppercase text-sm tracking-widest mb-1">Origen</h4>
                                    <p class="text-sm">Nuestros helados se elaboran con <span class="font-bold">leche de tambo propio</span>, destacando por el uso de ingredientes <span class="text-brand-primary font-bold">100% naturales</span>.</p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="bg-brand-primary text-white p-2 rounded-xl h-fit shadow-md">
                                    <x-mary-icon name="phosphor.ice-cream" class="w-6 h-6" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-brand-secondary uppercase text-sm tracking-widest mb-1">Productos</h4>
                                    <p class="text-sm">Además de helados artesanales, ofrecemos <span class="font-bold">tortas heladas, postres</span> y productos especiales de temporada, como roscas y panes dulces navideños.</p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="bg-brand-primary text-white p-2 rounded-xl h-fit shadow-md">
                                    <x-mary-icon name="phosphor.moped" class="w-6 h-6" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-brand-secondary uppercase text-sm tracking-widest mb-1">Servicios</h4>
                                    <p class="text-sm">Contamos con servicio de <span class="font-bold">delivery</span> (a través de WhatsApp o aplicaciones como PedidosYa) y retiro en sucursal.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Locations --}}
            <div class="lg:col-span-5 sticky top-24">
                <div class="bg-brand-primary p-1 rounded-[2rem] shadow-xl">
                    <div class="bg-white dark:bg-base-100 p-8 rounded-[1.9rem]">
                        <h3 class="text-2xl font-bold text-brand-primary font-display mb-6 flex items-center gap-2">
                            <x-mary-icon name="phosphor.map-pin-line" class="w-7 h-7 text-brand-secondary" />
                            Ubicaciones y Sucursales
                        </h3>
                        
                        <p class="text-sm text-base-content/70 mb-8 leading-relaxed">
                            Tenemos una fuerte presencia en el departamento <span class="font-bold text-brand-primary">General Obligado</span> y zonas aledañas, llevando la calidad Polijub a cada rincón.
                        </p>

                        <div class="space-y-8">
                            <div>
                                <h4 class="font-bold text-brand-secondary text-sm uppercase tracking-widest mb-4 border-l-4 border-brand-primary pl-3">Reconquista (Sede Principal)</h4>
                                <ul class="space-y-3">
                                    <li class="flex items-center gap-3 text-sm group">
                                        <x-mary-icon name="phosphor.storefront" class="w-5 h-5 text-brand-primary transition-transform group-hover:scale-110" />
                                        <span>Patricio Diez 1002</span>
                                    </li>
                                    <li class="flex items-center gap-3 text-sm group">
                                        <x-mary-icon name="phosphor.storefront" class="w-5 h-5 text-brand-primary transition-transform group-hover:scale-110" />
                                        <span>Pietropaolo 2001</span>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <h4 class="font-bold text-brand-secondary text-sm uppercase tracking-widest mb-4 border-l-4 border-brand-primary pl-3">Otras Localidades</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(['Avellaneda', 'Las Toscas', 'Romang', 'Villa Ocampo', 'Vera (Ruta 11)', 'Corrientes Capital'] as $city)
                                        <span class="px-3 py-1 bg-base-200 rounded-full text-[10px] font-bold uppercase text-base-content/60 border border-base-300">{{ $city }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 pt-8 border-t border-base-200 text-center">
                            <p class="text-xs text-base-content/50 mb-6 uppercase tracking-widest">Seguinos para promos exclusivas</p>
                            <div class="flex flex-col gap-3">
                                <x-mary-button label="Instagram Oficial" icon="phosphor.instagram-logo" link="https://www.instagram.com/polijub/" external class="btn-primary w-full shadow-lg" />
                                <span class="text-[10px] text-base-content/40 italic mt-2">Consultá por el clásico 2x1 en cuartos o potes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
