<footer class="bg-brand-primary text-white font-sans">
    <div class="container mx-auto px-4 py-8 md:px-6 lg:px-8 md:py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 lg:gap-16">
            <!-- Columna 1: POLINEWS (Suscripción) -->
            <div>
                <h3 class="text-3xl lg:text-4xl font-extrabold mb-5 uppercase tracking-wide">POLINEWS</h3>
                <p class="text-sm md:text-base mb-6 leading-relaxed">
                    Suscribete para recibir noticias, ofertas de suscripción y alertas sobre nuevos lanzamientos de
                    productos!
                </p>
                <form class="mb-6">
                    <p class="text-xs text-gray-300 mb-2 italic">*Tu correo electrónico</p>
                    <div class="flex">
                        <input type="email" placeholder="Email" aria-label="Email para suscripción"
                            class="flex-grow px-4 py-3 rounded-l-lg bg-white text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-secondary transition duration-200" />
                        <button type="submit" class="bg-white text-gray-800 px-6 py-3 rounded-r-lg font-semibold whitespace-nowrap
                                   hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-75
                                   transition duration-200 shadow-md">
                            Enviar
                        </button>
                    </div>
                </form>
                <hr class="border-gray-500 my-6 border-opacity-50">
            </div>

            <!-- Columna 2: CONTACTOS -->
            <div>
                <h3 class="text-3xl lg:text-4xl font-extrabold mb-5 uppercase tracking-wide">CONTACTOS:</h3>
                <ul class="space-y-4 text-sm md:text-base mb-8">
                    <li class="flex items-start">
                        <!-- Icono de ubicación -->
                        <x-phosphor-map-pin class="flex-shrink-0 h-6 w-6 text-brand-secondary mr-3" />
                        <span>Habegger y Obligado, Reconquista, Argentina, 3560</span>
                    </li>
                    <li class="flex items-start">
                        <!-- Icono de teléfono -->
                        <x-phosphor-phone class="flex-shrink-0 h-6 w-6 text-brand-secondary mr-3" />
                        <span>03482 42-8908</span>
                    </li>
                    <li class="flex items-start">
                        <!-- Icono de email -->
                        <x-phosphor-envelope class="flex-shrink-0 h-6 w-6 text-brand-secondary mr-3" />
                        <span>HeladoPolijub@gmail.com</span>
                    </li>

                </ul>
                <div class="mt-8 text-center">
                    <img src="{{ asset('images/SOCIOS.webp') }}" alt="Socios"
                        class="mx-auto w-full max-w-xs h-auto opacity-80 grayscale invert" />
                </div>
            </div>

            <!-- Columna 3: RRSS (Redes Sociales) -->
            <div>
                <h3 class="text-3xl lg:text-4xl font-extrabold mb-5 uppercase tracking-wide">RRSS:</h3>
                <p class="text-sm md:text-base mb-6 leading-relaxed">
                    Seguinos en cualquiera de nuestras Redes Sociales y enterate de todas las novedades de Polijub.
                    Promos, Sorteos, encuentros, contenidos, etc.
                </p>
                <div class="flex justify-center md:justify-start space-x-4 mb-8">
                    <!-- Instagram -->
                    <a href="#" aria-label="Instagram" class="w-10 h-10 rounded-full flex items-center justify-center
                                                         bg-gradient-to-br from-purple-500 via-pink-500 to-yellow-500
                                                         hover:scale-110 transition-transform duration-200 shadow-lg">
                        <x-phosphor-instagram-logo class="h-6 w-6 text-white" />
                    </a>

                    <!-- Facebook -->
                    <a href="#" aria-label="Facebook"
                        class="w-10 h-10 rounded-full flex items-center justify-center
                                                         bg-blue-600 hover:bg-blue-700 transition-colors duration-200 shadow-lg">
                        <x-phosphor-facebook-logo class="h-6 w-6 text-white" />
                    </a>

                    <!-- YouTube -->
                    <a href="#" aria-label="YouTube"
                        class="w-10 h-10 rounded-full flex items-center justify-center
                                                         bg-red-600 hover:bg-red-700 transition-colors duration-200 shadow-lg">
                        <x-phosphor-youtube-logo class="h-6 w-6 text-white" />
                    </a>

                    <!-- TikTok -->
                    <a href="#" aria-label="TikTok"
                        class="w-10 h-10 rounded-full flex items-center justify-center
                                                         bg-black hover:bg-gray-800 transition-colors duration-200 shadow-lg">
                        <x-phosphor-tiktok-logo class="h-6 w-6 text-white" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie de página final -->
    <div class="bg-teal-800 text-center py-4">
        <p class="text-sm text-gray-300">© {{ date('Y') }} Polijub. Todos los derechos reservados. | BELGRANO OESTE</p>
    </div>
</footer>