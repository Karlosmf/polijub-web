<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make existing FKs nullable
            $table->foreignId('user_id')->nullable()->change();
            $table->foreignId('branch_id')->nullable()->change();
            
            // Add guest/delivery info
            $table->string('guest_email')->nullable();
            $table->string('guest_phone')->nullable();
            $table->string('guest_name')->nullable();
            $table->string('guest_lastname')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zip')->nullable();
            $table->text('notes')->nullable();
            $table->string('payment_method')->nullable();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'guest_email', 'guest_phone', 'guest_name', 'guest_lastname',
                'address', 'city', 'province', 'zip', 'notes', 'payment_method'
            ]);
            // Reverting nullable changes is complex, skipping
        });
    }
};