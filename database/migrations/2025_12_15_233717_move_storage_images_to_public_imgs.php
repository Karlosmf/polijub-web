<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $storageProducts = storage_path('app/public/products');
        $publicProducts = public_path('imgs/products');

        if (File::exists($storageProducts)) {
            File::copyDirectory($storageProducts, $publicProducts);
            // Optionally delete old directory? Safer to keep for now or manual delete.
            // File::deleteDirectory($storageProducts);
        }

        $storageFlavors = storage_path('app/public/flavors');
        $publicFlavors = public_path('imgs/flavors');

        if (File::exists($storageFlavors)) {
            File::copyDirectory($storageFlavors, $publicFlavors);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse action defined for safety.
    }
};
