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

        Product::create([
            'name' => 'Dulce de Leche',
            'description' => 'El más rico dulce de leche',
            'price' => 10.00,
            'category_id' => $sabores->id,
            'is_active' => true
        ]);

        Product::create([
            'name' => 'Torta Almendrada',
            'description' => 'Torta helada de almendras',
            'price' => 20.00,
            'category_id' => $tortas->id,
            'is_active' => true
        ]);

        Product::create([
            'name' => 'Bombón Suizo',
            'description' => 'Bombón de chocolate con corazón de dulce de leche',
            'price' => 5.00,
            'category_id' => $postres->id,
            'is_active' => true
        ]);
    }
}
