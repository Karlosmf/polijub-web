<footer class="bg-brand-primary text-white font-sans">
    <div class="container mx-auto px-4 py-8 md:px-6 lg:px-8 md:py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 lg:gap-16">
            <!-- Columna 1: POLINEWS (Suscripción) -->
            <div>
                <h3 class="text-3xl lg:text-4xl font-extrabold mb-5 uppercase tracking-wide">POLINEWS</h3>
                <p class="text-sm md:text-base mb-6 leading-relaxed">
                    Suscribete para recibir noticias, ofertas de suscripción y alertas sobre nuevos lanzamientos de productos!
                </p>
                <form class="mb-6">
                    <p class="text-xs text-gray-300 mb-2 italic">*Tu correo electrónico</p>
                    <div class="flex">
                        <input
                            type="email"
                            placeholder="Email"
                            aria-label="Email para suscripción"
                            class="flex-grow px-4 py-3 rounded-l-lg bg-white text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-secondary transition duration-200"
                        />
                        <button
                            type="submit"
                            class="bg-white text-gray-800 px-6 py-3 rounded-r-lg font-semibold whitespace-nowrap
                                   hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-75
                                   transition duration-200 shadow-md"
                        >
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
                        <svg class="flex-shrink-0 h-6 w-6 text-brand-secondary mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Habegger y Obligado, Reconquista, Argentina, 3560</span>
                    </li>
                    <li class="flex items-start">
                        <!-- Icono de teléfono -->
                        <svg class="flex-shrink-0 h-6 w-6 text-brand-secondary mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>03482 42-8908</span>
                    </li>
                    <li class="flex items-start">
                        <!-- Icono de email -->
                        <svg class="flex-shrink-0 h-6 w-6 text-brand-secondary mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>HeladoPolijub@gmail.com</span>
                    </li>

                </ul>
                <div class="mt-8 text-center">
                    <img src="{{ asset('images/SOCIOS.webp') }}" alt="Socios" class="mx-auto w-full max-w-xs h-auto opacity-80 grayscale" />
                </div>
            </div>

            <!-- Columna 3: RRSS (Redes Sociales) -->
            <div>
                <h3 class="text-3xl lg:text-4xl font-extrabold mb-5 uppercase tracking-wide">RRSS:</h3>
                <p class="text-sm md:text-base mb-6 leading-relaxed">
                    Seguinos en cualquiera de nuestras Redes Sociales y enterate de todas las novedades de Polijub. Promos, Sorteos, encuentros, contenidos, etc.
                </p>
                <div class="flex justify-center md:justify-start space-x-4 mb-8">
                    <!-- Instagram -->
                    <a href="#" aria-label="Instagram" class="w-10 h-10 rounded-full flex items-center justify-center
                                                         bg-gradient-to-br from-purple-500 via-pink-500 to-yellow-500
                                                         hover:scale-110 transition-transform duration-200 shadow-lg">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#ffffff" d="M224.1 142.7c-25.4 0-46.1 20.7-46.1 46.1c0 11.3 2.7 21.8 7.5 31.1c-1.6 1.2-3.2 2.6-4.8 4c-11.1 9.2-20.7 19.8-28.7 31.6c-1.6 2.4-3.1 4.9-4.5 7.4c-1.4 2.5-2.7 5-3.9 7.6c-1.2 2.6-2.3 5.2-3.3 7.9c-1 2.7-1.9 5.4-2.7 8.2c-0.8 2.8-1.5 5.6-2.1 8.5c-0.6 2.9-1.1 5.8-1.5 8.8c-0.4 3-0.7 6-0.9 9.1c-0.2 3.1-0.3 6.2-0.3 9.4c0 25.4 20.7 46.1 46.1 46.1c11.3 0 21.8-2.7 31.1-7.5c1.2 1.6 2.6 3.2 4 4.8c9.2 11.1 19.8 20.7 31.6 28.7c2.4 1.6 4.9 3.1 7.4 4.5c2.5 1.4 5 2.7 7.6 3.9c2.6 1.2 5.2 2.3 7.9 3.3c2.7 1 5.4 1.9 8.2 2.7c2.8 0.8 5.6 1.5 8.5 2.1c2.9 0.6 5.8 1.1 8.8 1.5c3 0.4 6 0.7 9.1 0.9c3.1 0.2 6.2 0.3 9.4 0.3c25.4 0 46.1-20.7 46.1-46.1c0-11.3-2.7-21.8-7.5-31.1c1.6-1.2 3.2-2.6 4.8-4c11.1-9.2 20.7-19.8 28.7-31.6c1.6-2.4 3.1-4.9 4.5-7.4c1.4-2.5 2.7-5 3.9-7.6c1.2-2.6 2.3-5.2 3.3-7.9c1-2.7 1.9-5.4 2.7-8.2c0.8-2.8 1.5-5.6 2.1-8.5c0.6-2.9 1.1-5.8 1.5-8.8c0.4-3 0.7-6 0.9-9.1c0.2-3.1 0.3-6.2 0.3-9.4c0-25.4-20.7-46.1-46.1-46.1c-11.3 0-21.8 2.7-31.1 7.5c-1.2-1.6-2.6-3.2-4-4.8c-9.2-11.1-19.8-20.7-31.6-28.7c-2.4-1.6-4.9-3.1-7.4-4.5c-2.5-1.4-5-2.7-7.6-3.9c-2.6-1.2-5.2-2.3-7.9-3.3c-2.7-1-5.4-1.9-8.2-2.7c-2.8-0.8-5.6-1.5-8.5-2.1c-2.9-0.6-5.8-1.1-8.8-1.5c-3-0.4-6-0.7-9.1-0.9c-3.1-0.2-6.2-0.3-9.4-0.3zm-128 0c-25.4 0-46.1 20.7-46.1 46.1c0 11.3 2.7 21.8 7.5 31.1c-1.6 1.2-3.2 2.6-4.8 4c-11.1 9.2-20.7 19.8-28.7 31.6c-1.6 2.4-3.1 4.9-4.5 7.4c-1.4 2.5-2.7 5-3.9 7.6c-1.2 2.6-2.3 5.2-3.3 7.9c-1 2.7-1.9 5.4-2.7 8.2c-0.8 2.8-1.5 5.6-2.1 8.5c-0.6 2.9-1.1 5.8-1.5 8.8c-0.4 3-0.7 6-0.9 9.1c-0.2 3.1-0.3 6.2-0.3 9.4c0 25.4 20.7 46.1 46.1 46.1c11.3 0 21.8-2.7 31.1-7.5c1.2 1.6 2.6 3.2 4 4.8c9.2 11.1 19.8 20.7 31.6 28.7c2.4 1.6 4.9 3.1 7.4 4.5c2.5 1.4 5 2.7 7.6 3.9c2.6 1.2 5.2 2.3 7.9 3.3c2.7 1 5.4 1.9 8.2 2.7c2.8 0.8 5.6 1.5 8.5 2.1c2.9 0.6 5.8 1.1 8.8 1.5c3 0.4 6 0.7 9.1 0.9c3.1 0.2 6.2 0.3 9.4 0.3c25.4 0 46.1-20.7 46.1-46.1c0-11.3-2.7-21.8-7.5-31.1c1.6-1.2 3.2-2.6 4.8-4c11.1-9.2 20.7-19.8 28.7-31.6c1.6-2.4 3.1-4.9 4.5-7.4c1.4-2.5 2.7-5 3.9-7.6c1.2-2.6 2.3-5.2 3.3-7.9c1-2.7 1.9-5.4 2.7-8.2c0.8-2.8 1.5-5.6 2.1-8.5c0.6-2.9 1.1-5.8 1.5-8.8c0.4-3 0.7-6 0.9-9.1c0.2-3.1 0.3-6.2 0.3-9.4c0-25.4-20.7-46.1-46.1-46.1c-11.3 0-21.8 2.7-31.1 7.5c-1.2-1.6-2.6-3.2-4-4.8c-9.2-11.1-19.8-20.7-31.6-28.7c-2.4-1.6-4.9-3.1-7.4-4.5c-2.5-1.4-5-2.7-7.6-3.9c-2.6-1.2-5.2-2.3-7.9-3.3c-2.7-1-5.4-1.9-8.2-2.7c-2.8-0.8-5.6-1.5-8.5-2.1c-2.9-0.6-5.8-1.1-8.8-1.5c-3-0.4-6-0.7-9.1-0.9c-3.1-0.2-6.2-0.3-9.4-0.3zM192 0C86 0 0 86 0 192v128c0 106 86 192 192 192h128c106 0 192-86 192-192V192c0-106-86-192-192-192H192zm224 192v128c0 88.2-71.8 160-160 160H192c-88.2 0-160-71.8-160-160V192c0-88.2 71.8-160 160-160h128c88.2 0 160 71.8 160 160zM160 192a64 64 0 1 0 0 128 64 64 0 1 0 0-128zm-64 64a128 128 0 1 1 256 0 128 128 0 1 1 -256 0zM384 112a32 32 0 1 0 0 64 32 32 0 1 0 0-64z"/></svg>
                    </a>

                    <!-- Facebook -->
                    <a href="#" aria-label="Facebook" class="w-10 h-10 rounded-full flex items-center justify-center
                                                         bg-blue-600 hover:bg-blue-700 transition-colors duration-200 shadow-lg">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                          <path d="M12 2.04C6.5 2.04 2 6.53 2 12.04c0 5.05 3.69 9.27 8.5 9.96v-7h-2.5v-2.91h2.5v-2.18c0-2.43 1.48-3.76 3.64-3.76 1.04 0 1.94.08 2.2.12v2.54h-1.5c-1.2 0-1.44.57-1.44 1.41v1.87h2.9l-.47 2.91h-2.43v7c4.81-.69 8.5-4.91 8.5-9.96 0-5.51-4.5-10-9.96-10z"/>
                        </svg>
                    </a>

                    <!-- YouTube -->
                    <a href="#" aria-label="YouTube" class="w-10 h-10 rounded-full flex items-center justify-center
                                                         bg-red-600 hover:bg-red-700 transition-colors duration-200 shadow-lg">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                          <path d="M21.543 6.498C22 8.01 22 12 22 12s0 3.99-0.457 5.502c-0.254 0.985-0.997 1.76-1.938 2.022C18.08 20 12 20 12 20s-6.08 0-7.605-0.476c-0.94-0.262-1.683-1.037-1.938-2.022C2 15.99 2 12 2 12s0-3.99 0.457-5.502c0.254-0.985 0.997-1.76 1.938-2.022C5.92 4 12 4 12 4s6.08 0 7.605 0.476c0.94 0.262 1.683 1.037 1.938 2.022zM9.99 15.49L15.005 12 9.99 8.51V15.49z"/>
                        </svg>
                    </a>

                    <!-- TikTok -->
                    <a href="#" aria-label="TikTok" class="w-10 h-10 rounded-full flex items-center justify-center
                                                         bg-black hover:bg-gray-800 transition-colors duration-200 shadow-lg">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#ffffff" d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V276a74 74 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.8 22.92C392.3 101.4 448 171.5 448 209.9z"/></svg>
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