<div>
    {{-- Hero Section --}}
    <div class="relative h-[400px] w-full bg-cover bg-center" style="background-image: url('{{ asset('storage/imgs/background.webp') }}');">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white p-4">
            <h1 class="text-5xl font-bold font-display uppercase tracking-widest mb-4">Sobre Nosotros</h1>
            <p class="text-xl font-light max-w-2xl">Más de 40 años endulzando el noreste de Santa Fe con helado artesanal de calidad.</p>
        </div>
    </div>

    {{-- Content Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        {{-- Intro --}}
        <div class="mb-16 text-center">
            <h2 class="text-3xl font-bold text-brand-primary mb-6 font-display">Nuestra Historia</h2>
            <p class="text-lg text-gray-700 leading-relaxed max-w-4xl mx-auto">
                Polijub es una reconocida cadena de heladerías artesanales con más de 40 años de trayectoria en la región del noreste de Santa Fe, Argentina. Desde nuestros inicios, nos hemos comprometido a ofrecer productos de la más alta calidad, elaborados con pasión y dedicación.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start mb-16">
            {{-- Features --}}
            <div class="space-y-8">
                <h3 class="text-2xl font-bold text-brand-secondary font-display border-b pb-2">Características Principales (2025)</h3>
                
                <div class="flex gap-4">
                    <div class="bg-brand-primary/10 p-3 rounded-full h-fit">
                        <x-mary-icon name="phosphor.plant" class="w-8 h-8 text-brand-primary" />
                    </div>
                    <div>
                        <h4 class="font-bold text-lg mb-1">Origen Natural</h4>
                        <p class="text-gray-600">Sus helados se elaboran con leche de tambo propio, destacando por el uso de ingredientes 100% naturales.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="bg-brand-primary/10 p-3 rounded-full h-fit">
                        <x-mary-icon name="phosphor.ice-cream" class="w-8 h-8 text-brand-primary" />
                    </div>
                    <div>
                        <h4 class="font-bold text-lg mb-1">Variedad de Productos</h4>
                        <p class="text-gray-600">Además de helados artesanales, ofrecen tortas heladas, postres y productos especiales de temporada, como roscas y panes dulces navideños.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="bg-brand-primary/10 p-3 rounded-full h-fit">
                        <x-mary-icon name="phosphor.moped" class="w-8 h-8 text-brand-primary" />
                    </div>
                    <div>
                        <h4 class="font-bold text-lg mb-1">Servicios</h4>
                        <p class="text-gray-600">Cuentan con servicio de delivery (a través de WhatsApp o aplicaciones como PedidosYa) y retiro en sucursal.</p>
                    </div>
                </div>
            </div>

            {{-- Locations --}}
            <div class="bg-gray-50 rounded-2xl p-8 shadow-sm border border-gray-100">
                <h3 class="text-2xl font-bold text-brand-secondary font-display mb-6">Ubicaciones y Sucursales</h3>
                <p class="text-gray-700 mb-4">La empresa tiene una fuerte presencia en el departamento General Obligado y zonas aledañas.</p>
                
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <x-mary-icon name="phosphor.map-pin" class="w-6 h-6 text-brand-primary flex-shrink-0 mt-1" />
                        <div>
                            <span class="font-bold block">Reconquista (Sede Principal)</span>
                            <span class="text-gray-600 text-sm">Patricio Diez 1002 y Pietropaolo 2001.</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <x-mary-icon name="phosphor.storefront" class="w-6 h-6 text-brand-primary flex-shrink-0 mt-1" />
                        <div>
                            <span class="font-bold block">Otras Localidades</span>
                            <span class="text-gray-600 text-sm">Avellaneda, Las Toscas, Romang, Villa Ocampo, Vera (sobre Ruta 11) y Corrientes Capital.</span>
                        </div>
                    </li>
                </ul>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500 mb-4">
                        Para consultar promociones vigentes (como el clásico 2x1 en cuartos o potes), puedes visitar nuestro Instagram oficial.
                    </p>
                    <x-mary-button label="Ver en Instagram" icon="phosphor.instagram-logo" link="https://www.instagram.com/polijub/" external class="btn-outline btn-primary w-full" />
                </div>
            </div>
        </div>

    </div>
</div>
