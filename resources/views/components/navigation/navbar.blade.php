<nav class="bg-[#3E9B8A] text-white p-4">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Logo -->
        <a href="/" class="text-2xl font-bold">
            <img src="/Users/carlitos/Projects/Polijub/polijubweb/public/apple-touch-icon.png" alt="Polijub Logo" class="h-10">
        </a>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-4">
            <a href="#" class="hover:text-gray-300">PRODUCTOS</a>
            <a href="#" class="hover:text-gray-300">TIENDA</a>
            <a href="#" class="hover:text-gray-300">DELIVERY</a>
            <a href="#" class="hover:text-gray-300">PRECIOS</a>
            <a href="#" class="hover:text-gray-300">NOSOTROS</a>
        </div>

        <!-- Right side icons -->
        <div class="hidden md:flex items-center space-x-4">
            <a href="#" class="hover:text-gray-300 flex items-center">
                <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Entrar
            </a>
            <a href="#" class="hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4z"></path></svg>
            </a>
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
            <button id="mobile-menu-button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden mt-4">
        <a href="#" class="block py-2 px-4 text-sm hover:bg-[#2C3E50]">PRODUCTOS</a>
        <a href="#" class="block py-2 px-4 text-sm hover:bg-[#2C3E50]">TIENDA</a>
        <a href="#" class="block py-2 px-4 text-sm hover:bg-[#2C3E50]">DELIVERY</a>
        <a href="#" class="block py-2 px-4 text-sm hover:bg-[#2C3E50]">PRECIOS</a>
        <a href="#" class="block py-2 px-4 text-sm hover:bg-[#2C3E50]">NOSOTROS</a>
        <a href="#" class="block py-2 px-4 text-sm hover:bg-[#2C3E50]">Entrar</a>
        <a href="#" class="block py-2 px-4 text-sm hover:bg-[#2C3E50]">Carrito</a>
    </div>

    <script>
        document.getElementById('mobile-menu-button').onclick = function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
</nav>
