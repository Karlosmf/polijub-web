<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sabores = Category::where('slug', 'sabores-tradicionales')->first();
        $tortas = Category::where('slug', 'tortas-heladas')->first();
        $postres = Category::where('slug', 'postres')->first();
        $paletas = Category::where('slug', 'paletas')->first();
        $granel = Category::where('slug', 'helados-granel')->first();

        // Productos a Granel (Formatos)
        if ($granel) {
            Product::create([
                'name' => 'Cucurucho',
                'description' => 'Crocante cucurucho con 2 bochas de helado a elección.',
                'price' => 2500.00,
                'category_id' => $granel->id,
                'image' => 'potehelado.webp', // Placeholder
                'is_active' => true
            ]);

            Product::create([
                'name' => '1/4 kg Helado',
                'description' => 'Pote de un cuarto kilo. Hasta 3 sabores.',
                'price' => 4500.00,
                'category_id' => $granel->id,
                'image' => 'potehelado.webp',
                'is_active' => true
            ]);

            Product::create([
                'name' => '1/2 kg Helado',
                'description' => 'Pote de medio kilo. Hasta 4 sabores.',
                'price' => 8000.00,
                'category_id' => $granel->id,
                'image' => 'potehelado.webp',
                'is_active' => true
            ]);

            Product::create([
                'name' => '1 kg Helado',
                'description' => 'Pote de un kilo. Hasta 5 sabores.',
                'price' => 15000.00,
                'category_id' => $granel->id,
                'image' => 'potehelado.webp',
                'is_active' => true
            ]);
        }

        Product::create([
            'name' => 'Torta Almendrada',
            'description' => 'Torta helada de almendras',
            'price' => 20.00,
            'category_id' => $tortas->id,
            'image' => 'Torta.webp',
            'is_active' => true
        ]);

        Product::create([
            'name' => 'Bombón Suizo',
            'description' => 'Bombón de chocolate con corazón de dulce de leche',
            'price' => 5.00,
            'category_id' => $postres->id,
            'image' => 'helados.webp',
            'is_active' => true
        ]);

        if ($paletas) {
            Product::create([
                'name' => 'Paleta Frutal',
                'description' => 'Paleta de agua sabor frutilla',
                'price' => 3.50,
                'category_id' => $paletas->id,
                'image' => 'helados.webp', // Placeholder
                'is_active' => true
            ]);
        }
    }
}
