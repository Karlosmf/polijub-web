<div class="bg-brand-primary text-white py-20">
    <div class="container mx-auto text-center">
        <h2 class="text-4xl font-bold mb-10">Sabores 100% Naturales</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach ($products as $product)
                <div class="card bg-base-100 shadow-xl">
                    <figure><img src="/sabores.avif" alt="{{ $product->name }}" /></figure>
                    <div class="card-body">
                        <h2 class="card-title text-black">{{ $product->name }}</h2>
                        <p class="text-black">{{ $product->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>