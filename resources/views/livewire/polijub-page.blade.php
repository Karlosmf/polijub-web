<div>
<!-- Contenedor principal de la página -->
<main class="container mx-auto">

<x-navigation.navbar />

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
src="https://placehold.co/500x300/FFCOCB/333333?text=Producto+Natural" alt="Ingredientes naturales para
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
<footer class="bg-footer-fondo text-white mt-20" style="background-image: url('footer.png');
background-size: cover; background-position: center;">
<div class="container mx-auto py-10 px-4 text-center bg-black bg-opacity-50">
<h2 class="text-2xl font-bold mb-4">Suscríbete a Novedades</h2>
<p class="mb-6">Recibe promociones y noticias sobre nuevos sabores directamente en
tu correo.</p>
<form id="subscriptionForm" class="max-w-md mx-auto">
<div class="flex">
<input type="email" id="emailInput" placeholder="tu.correo@ejemplo.com" required
class="w-full rounded-l-lg p-3 text-gray-800 focus:outline-none">
<button type="submit" class="bg-brand-primary text-white font-bold py-3 px-6
rounded-r-lg hover:bg-opacity-80 transition-colors">
Suscribir
</button>
</div>
<p id="feedbackMessage" class="mt-3 text-green-400 h-5"></p>
</form>
<div class="mt-8 border-t border-gray-700 pt-6">
<p>® {{ date('Y') }} Polijub Heladería. Todos los derechos reservados.</p>
</div>
</div>
</footer>

<!-- Bloque de JavaScript para la suscripción -->
@push('scripts')
<script src="{{ asset('js/subscription.js') }}"></script>
@endpush
</div>