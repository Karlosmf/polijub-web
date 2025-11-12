<div class="container mx-auto py-20">
    <div class="flex flex-col md:flex-row">
        <div class="w-full md:w-1/4">
            <h2 class="text-2xl font-bold mb-5">Categorías</h2>
            <ul class="menu bg-base-200 w-56 rounded-box">
                <li><a wire:click="$set('selectedCategory', null)">Todas</a></li>
                @foreach ($categories as $category)
                    <li><a wire:click="$set('selectedCategory', {{ $category->id }})">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="w-full md:w-3/4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach ($products as $product)
                    <div class="card bg-base-100 shadow-xl">
                        <figure><img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" /></figure>
                        <div class="card-body">
                            <h2 class="card-title text-black">{{ $product->name }}</h2>
                            <p class="text-black">{{ $product->description }}</p>
                            <div class="card-actions justify-end">
                                <button class="btn btn-primary bg-brand-secondary">Agregar al carrito</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>