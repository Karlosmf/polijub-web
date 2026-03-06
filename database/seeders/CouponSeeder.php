<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cupón de Porcentaje (10%)
        Coupon::create([
            'code' => 'BIENVENIDA10',
            'type' => 'percentage',
            'value' => 10.00,
            'is_active' => true,
            'max_uses' => 100,
            'starts_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMonths(3),
        ]);

        // 2. Cupón de Importe Fijo ($1000)
        Coupon::create([
            'code' => 'PROMO1000',
            'type' => 'fixed_amount',
            'value' => 1000.00,
            'is_active' => true,
            'max_uses' => 50,
            'starts_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMonth(),
        ]);

        // 3. Cupón de Canje de Producto (Cucurucho Gratis)
        $product = Product::where('name', 'Cucurucho')->first();
        if ($product) {
            Coupon::create([
                'code' => 'CUCURUCHO_FREE',
                'type' => 'fixed_product',
                'product_id' => $product->id,
                'is_active' => true,
                'max_uses' => 20,
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addWeeks(2),
            ]);
        }

        // 4. Cupón Exclusivo para un Usuario (si existe el Admin)
        $admin = User::where('email', 'admin@polijub.com')->first();
        if ($admin) {
            Coupon::create([
                'code' => 'SUPERMERCADOX10%',
                'type' => 'percentage',
                'value' => 10.00,
                'user_id' => $admin->id,
                'is_active' => true,
                'max_uses' => 1, // Single use for this specific person
            ]);
        }
    }
}
