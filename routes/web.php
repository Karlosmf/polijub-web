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

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    request()->session()->flush();
    request()->session()->forget('is_guest_login'); // Eliminar la bandera de invitado
    return redirect('/');
});

Route::get('/clear/{option?}', function ($option = null) {
    $logs = [];
    // if option is 'prod' then run composer install --optimize-autoloader --no-dev
    if ($option == 'prod') {
        $logs['Composer Install for PROD'] = Artisan::call('composer install --optimize-autoloader --no-dev');
    }

    $maintenance = ($option == "cache") ? [
        'Flush' => 'cache:flush',
    ] : [
        //'DebugBar'=>'debugbar:clear',
        'Storage Link' => 'storage:link',
        'Config' => 'config:clear',
        'Optimize Clear' => 'optimize:clear',
        'Optimize' => 'optimize',
        'Route Clear' => 'route:clear',
        'Route Cache' => 'route:cache',
        'View Clear' => 'view:clear',
        'View Cache' => 'view:cache',
        'Cache Clear' => 'cache:clear',
        'Cache Config' => 'config:cache',
    ];

    foreach ($maintenance as $key => $value) {
        try {
            Artisan::call($value);
            $logs[$key] = '✔️';
        } catch (\Exception $e) {
            $logs[$key] = '❌' . $e->getMessage();
        }
    }
    return "<pre>" . print_r($logs, true) . "</pre><hr />";
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

require __DIR__ . '/auth.php';
