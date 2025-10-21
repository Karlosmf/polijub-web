<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Sabores Tradicionales',
            'slug' => 'sabores-tradicionales'
        ]);

        Category::create([
            'name' => 'Tortas Heladas',
            'slug' => 'tortas-heladas'
        ]);

        Category::create([
            'name' => 'Postres',
            'slug' => 'postres'
        ]);
    }
}
