<div>
<!-- Contenedor principal de la página -->
<main class="container mx-auto">

<!-- Sección del Héroe (Header) -->
<header class="text-center my-12 p-8 bg-accent-pink rounded-lg shadow-lg">
<h1 class="text-4xl font-bold text-brand-primary tracking-wider">
FEB/14... MES DEL AMOR!
</h1>
<p class="text-gray-700 mt-2">
Disfruta de nuestros sabores especiales para celebrar.
</p>
</header>

<!-- Sección de Sabores -->
<section id="sabores" class="my-16 text-center">
<h2 class="text-3xl font-bold mb-4">SABORES QUE TE HARÁN DECIR "¡GUAU!"</h2>
<p class="max-w-3xl mx-auto mb-8 text-gray-600">
Desde los clásicos irresistibles hasta creaciones únicas que no encontrarás en otro lugar.
Cada cucharada es una nueva aventura.
</p>
<a href="#" class="btn-polijub-primary">
Ver Todos los Sabores
</a>
</section>

<!-- Sección de Calidad 100% Natural -->
<section id="calidad" class="my-16 p-10 bg-white rounded-lg shadow-md flex items-center">
<div class="w-1/2">
<img
src="{{ asset('sabores.avif') }}" alt="Ingredientes naturales para
helado" class="rounded-lg">
</div>
<div class="w-1/2 pl-10">
<h2 class="text-3xl font-bold mb-3">100% NATURAL, 100% DELICIOSO</h2>
<h3 class="text-xl text-gray-500 mb-4">Calidad garantizada por "Establecimiento LOS
NENITOS"</h3>
<p class="text-gray-600">
Utilizamos solo los mejores ingredientes, frescos y sin conservantes artificiales.
Creemos que el mejor sabor proviene de la naturaleza.
</p>
</div>
</section>
</main>

<!-- Bloque de JavaScript para la suscripción -->
@push('scripts')
<script src="{{ asset('js/subscription.js') }}"></script>
@endpush
</div>