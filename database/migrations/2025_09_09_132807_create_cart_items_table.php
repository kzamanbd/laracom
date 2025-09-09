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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('cart_id')->constrained('carts')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();

            // Item details at time of adding to cart (snapshot for price consistency)
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 14, 2); // Price when added to cart
            $table->decimal('total_price', 14, 2); // quantity * unit_price
            $table->string('currency', 3)->default('USD');

            // Product snapshot for historical accuracy
            $table->string('product_name'); // In case product name changes
            $table->string('product_sku')->nullable();
            $table->json('product_attributes')->nullable(); // Color, size, etc. at time of adding

            // Tax information
            $table->foreignId('tax_id')->nullable()->constrained('taxes')->nullOnDelete();
            $table->decimal('tax_rate', 8, 4)->default(0); // Snapshot of tax rate
            $table->decimal('tax_amount', 14, 2)->default(0);

            // Additional metadata
            $table->json('meta')->nullable(); // Custom options, gift wrap, etc.
            $table->text('notes')->nullable(); // Customer notes for this item

            $table->timestamps();

            // Indexes
            $table->index(['cart_id', 'product_id']);
            $table->index(['product_id']);

            // Prevent duplicate items with same attributes
            $table->unique(['cart_id', 'product_id', 'product_attributes'], 'unique_cart_product_attributes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
