<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Livewire\Pages\PolijubPage;
use App\Livewire\Contact;
use App\Livewire\Shop\ProductList;
use App\Livewire\Delivery\OrderForm;
use Livewire\Volt\Volt;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\TagManager;
use App\Livewire\Admin\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

/**
 * @route GET /
 * @description Displays the default Laravel welcome page.
 */
Route::get('/', function () {
    return view('home');
});

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    request()->session()->flush();
    request()->session()->forget('is_guest_login'); // Remove guest flag
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
 * @description Defines the main route for the Polijub landing page.
 * Loads the Livewire 'PolijubPage' component which will render the full view.
 * Named 'polijub.home' for easy reference in the application.
 */
Route::get('/polijub', PolijubPage::class)->name('polijub.home');


Route::get('/shop', ProductList::class)->name('shop.products');
Route::get('/delivery', OrderForm::class)->name('delivery.form');
Route::get('/contact', Contact::class)->name('contact.index');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Product Routes
    Volt::route('/products', 'admin.products.index')->name('products');
    Volt::route('/products/create', 'admin.products.crud')->name('products.create');
    Volt::route('/products/{id}/edit', 'admin.products.crud')->name('products.edit');

    // Flavor Routes
    Volt::route('/flavors', 'admin.flavors.index')->name('flavors');
    Volt::route('/flavors/create', 'admin.flavors.crud')->name('flavors.create');
    Volt::route('/flavors/{id}/edit', 'admin.flavors.crud')->name('flavors.edit');
    
    // Order Routes
    Volt::route('/orders', 'admin.orders.index')->name('orders');
    Volt::route('/orders/{order}', 'admin.orders.show')->name('orders.show');

    Route::get('/tags', TagManager::class)->name('tags');
    Volt::route('/carousel', 'admin.carousel-manager')->name('carousel');
    Route::get('/profile', Profile::class)->name('profile');
});

Volt::route('/flavors', 'pages.flavors-page')->name('flavors.index');

// Checkout Routes
Volt::route('/checkout/cart', 'checkout.cart-review')->name('checkout.cart');
Volt::route('/checkout/delivery', 'checkout.delivery-info')->name('checkout.delivery');
Volt::route('/checkout/payment', 'checkout.payment-details')->name('checkout.payment');

// Provisional routes for "100% NATURAL" section
Route::get('/natural-products', function () {
    return 'Natural Products Page - Under Construction';
})->name('natural_products');

Route::get('/los-nenitos', function () {
    return 'Los Nenitos Establishment Page - Under Construction';
})->name('los_nenitos_establishment');

require __DIR__ . '/auth.php';