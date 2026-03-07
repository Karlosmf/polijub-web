<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Livewire\Pages\PolijubPage;
use App\Livewire\Pages\Contact;
Route::get('/contact', Contact::class)->name('contact.index');
use App\Livewire\Shop\ProductList;
use App\Livewire\Delivery\OrderForm;
use Livewire\Volt\Volt;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\TagManager;
use App\Livewire\Admin\CouponManager;
use App\Livewire\Admin\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/**
 * @route GET /
 */
Route::get('/', function () {
    return view('home');
});

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    request()->session()->flush();
    return redirect('/');
});

Route::get('/clear/{option?}', function ($option = null) {
    $logs = [];
    $maintenance = [
        'Storage Link' => 'storage:link',
        'Config' => 'config:clear',
        'Optimize Clear' => 'optimize:clear',
        'Route Clear' => 'route:clear',
        'View Clear' => 'view:clear',
        'Cache Clear' => 'cache:clear',
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
 * Public Pages
 */
Route::get('/polijub', PolijubPage::class)->name('polijub.home');
Route::get('/shop', ProductList::class)->name('shop.products');
Route::get('/delivery', OrderForm::class)->name('delivery.form');
Route::get('/contact', Contact::class)->name('contact.index');
Route::get('/about', \App\Livewire\Pages\About::class)->name('about.index');

/**
 * Customer Routes (No /admin prefix)
 */
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/dashboard', function() {
        if (auth()->user()->isAdmin() || auth()->user()->isManager()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('profile');
    })->name('dashboard');
});

/**
 * Admin & Staff Routes
 */
Route::middleware(['auth', 'role:admin,manager'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile'); // Keep for admin layout consistency
    
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
    Route::get('/coupons', CouponManager::class)->name('coupons');
    Route::get('/users', \App\Livewire\Admin\UserManager::class)->name('users');
    
    Volt::route('/settings', 'admin.settings-manager')->name('settings');
    Volt::route('/carousel', 'admin.carousel-manager')->name('carousel');
    Route::get('/themes', \App\Livewire\Admin\Themes::class)->name('themes');
});

Volt::route('/flavors', 'pages.flavors-page')->name('flavors.index');

// Checkout Routes
Volt::route('/checkout/cart', 'checkout.cart-review')->name('checkout.cart');
Volt::route('/checkout/delivery', 'checkout.delivery-info')->name('checkout.delivery');
Volt::route('/checkout/payment', 'checkout.payment-details')->name('checkout.payment');
Volt::route('/checkout/success', 'checkout.order-success')->name('checkout.success');

require __DIR__ . '/auth.php';
