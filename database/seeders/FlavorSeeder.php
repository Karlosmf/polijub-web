<?php

namespace Database\Seeders;

use App\Models\Flavor;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlavorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define tags colors map for consistency
        $tagColors = [
            'crema' => '#fcd34d', // yellow-300
            'agua' => '#60a5fa', // blue-400
            'premium' => '#1e293b', // slate-800
            'clasico' => '#d97706', // amber-600
            'frutal' => '#f87171', // red-400
            'vegano' => '#4ade80', // green-400
            'singluten' => '#a8a29e', // stone-400
            'refrescante' => '#22d3ee', // cyan-400
            'sinazucar' => '#818cf8', // indigo-400
            'diabetico' => '#6366f1', // indigo-500
            'tradicional' => '#b45309', // amber-700
            'tropical' => '#facc15', // yellow-400
        ];

        // Define some sample flavors
        $flavors = [
            [
                'name' => 'Chocolate Suizo',
                'description' => 'El clásico chocolate con trozos de chocolate suizo. Intenso y cremoso.',
                'image' => 'images/flavors/chocolate_suizo.webp', 
                'tags' => ['crema', 'premium'],
                'is_active' => true,
            ],
            [
                'name' => 'Vainilla con Dulce de Leche',
                'description' => 'Suave vainilla combinada con el auténtico dulce de leche argentino.',
                'image' => 'images/flavors/vainilla_ddl.webp',
                'tags' => ['crema', 'clasico'],
                'is_active' => true,
            ],
            [
                'name' => 'Limón al Agua',
                'description' => 'Refrescante sorbete de limón, ideal para los días calurosos.',
                'image' => 'images/flavors/limon_agua.webp',
                'tags' => ['agua', 'frutal', 'vegano'],
                'is_active' => true,
            ],
            [
                'name' => 'Frutos del Bosque (sin gluten)',
                'description' => 'Mix de frutos rojos del bosque. Apto para celíacos.',
                'image' => 'images/flavors/frutos_bosque.webp',
                'tags' => ['crema', 'frutal', 'singluten'],
                'is_active' => true,
            ],
            [
                'name' => 'Menta Granizada',
                'description' => 'Cremoso helado de menta con trozos de chocolate amargo.',
                'image' => 'images/flavors/menta_granizada.webp',
                'tags' => ['crema', 'refrescante'],
                'is_active' => true,
            ],
            [
                'name' => 'Dulce de Leche Tentación (Sin Azúcar)',
                'description' => 'El inigualable sabor del dulce de leche, ahora sin azúcar, para cuidar tu salud sin renunciar al placer.',
                'image' => 'images/flavors/ddl_sin_azucar.webp',
                'tags' => ['crema', 'sinazucar', 'diabetico'],
                'is_active' => true,
            ],
            [
                'name' => 'Sambayón Italiano',
                'description' => 'Un sabor exquisito y tradicional, hecho con yemas de huevo, azúcar, vino Marsala y un toque de brandy.',
                'image' => 'images/flavors/sambayon.webp',
                'tags' => ['crema', 'tradicional'],
                'is_active' => true,
            ],
            [
                'name' => 'Coco al Agua',
                'description' => 'El exótico sabor del coco, preparado al agua para una textura ligera y refrescante.',
                'image' => 'images/flavors/coco_agua.webp',
                'tags' => ['agua', 'tropical', 'vegano'],
                'is_active' => true,
            ],
        ];

        foreach ($flavors as $flavorData) {
            $tagNames = $flavorData['tags'];
            unset($flavorData['tags']);

            $flavor = Flavor::create($flavorData);

            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['color' => $tagColors[$tagName] ?? '#3E9B8A']
                );
                $flavor->tags()->attach($tag->id);
            }
        }
    }
}
