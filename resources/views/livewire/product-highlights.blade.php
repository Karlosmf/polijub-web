<!-- Section: 100% Natural -->
<div class="relative bg-white py-24 sm:py-32">

    <!-- Decorative Wave Top (Organic Shape) -->
    <div class="absolute top-0 left-0 w-full h-[75px] sm:h-[120px] text-white z-0" style="transform: translateY(-50%);">
        <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 1440 100" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 20C240 80 480 0 720 20s480 80 720 0V100H0V20Z"/>
        </svg>
    </div>

    <!-- Background Bottle Image: Positioned behind content with low opacity -->
    <div class="absolute inset-0 bg-no-repeat bg-center opacity-10" style="background-image: url('/images/bottle.svg'); background-size: contain; background-position: 80% 50%;"></div>

    <!-- Content Container -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-12">

            <!-- Left Content Block -->
            <div class="lg:w-1/2 text-center lg:text-left">
                <h2 class="text-5xl md:text-6xl font-bold uppercase text-brand-primary">
                    100% NATURAL
                </h2>
                <p class="mt-4 max-w-md mx-auto lg:mx-0 text-gray-700 text-lg">
                    Tenemos el orgullo de poder decir que nuestra materia prima principal, la leche es de nuestra elaboración y nadie mejor que nosotras para saber cómo crecen nuestros MEJORES SOCIAS!!!
                </p>
                <div class="mt-8">
                    <a href="{{ route('natural_products') }}" class="inline-block bg-brand-secondary hover:bg-brand-primary text-white uppercase font-semibold py-3 px-8 rounded-full transition-colors duration-300">
                        Descubrí más de 100%NAT
                    </a>
                </div>
            </div>

            <!-- Right Content Block -->
            <div class="w-full lg:w-1/2 flex flex-col items-center lg:items-end text-center lg:text-right">
                <div class="relative">
                    <!-- Optional: Inline logo for "Los Nenitos" -->
                    <!-- <img src="/images/los-nenitos-logo.svg" alt="Los Nenitos Logo" class="h-12 mx-auto lg:mx-0 mb-4"> -->
                    <h3 class="text-4xl md:text-5xl font-light text-gray-300 leading-tight">
                        Producto elaborado con <br> ingredientes 100% natural
                    </h3>
                </div>
                 <div class="mt-8">
                    <a href="{{ route('los_nenitos_establishment') }}" class="inline-block bg-accent-blue hover:opacity-90 text-white uppercase font-semibold py-3 px-8 rounded-full transition-opacity duration-300">
                        Establecimiento LOS NÉÑITOS
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Decorative Wave Bottom (Organic Shape) -->
    <div class="absolute bottom-0 left-0 w-full h-[75px] sm:h-[120px] text-white z-0" style="transform: translateY(50%) rotate(180deg);">
        <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 1440 100" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 20C240 80 480 0 720 20s480 80 720 0V100H0V20Z"/>
        </svg>
    </div>

</div>