<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PolijubPage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web para tu aplicación. Estas
| rutas son cargadas por el RouteServiceProvider y todas ellas
| serán asignadas al grupo de middleware "web".
|
*/

/**
 * @route GET /
 * @description Muestra la página de bienvenida por defecto de Laravel.
 */
Route::get('/', function () {
    return view('home');
});

/**
 * @route GET /polijub
 * @description Define la ruta principal para la landing page de Polijub.
 * Carga el componente de Livewire 'PolijubPage' que renderizará la vista completa.
 * Se le asigna el nombre 'polijub.home' para facilitar la referencia en la aplicación.
 */
Route::get('/polijub', PolijubPage::class)->name('polijub.home');

use App\Livewire\Shop\ProductList;

Route::get('/tienda', ProductList::class)->name('shop.products');

require __DIR__.'/auth.php';