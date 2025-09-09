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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // Support for both guest and authenticated users
            $table->string('session_id')->nullable()->index(); // For guest users
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete(); // For authenticated users
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete(); // Optional customer association

            // Cart metadata
            $table->string('currency', 3)->default('USD');
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('discount_total', 14, 2)->default(0);
            $table->decimal('tax_total', 14, 2)->default(0);
            $table->decimal('shipping_total', 14, 2)->default(0);
            $table->decimal('total', 14, 2)->default(0);

            // Cart state
            $table->enum('status', ['active', 'abandoned', 'converted', 'expired'])->default('active')->index();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index(); // For automatic cleanup

            // Additional metadata
            $table->json('meta')->nullable(); // Coupon codes, notes, etc.
            $table->string('coupon_code')->nullable()->index();
            $table->decimal('coupon_discount', 14, 2)->default(0);

            $table->timestamps();

            // Indexes for performance
            $table->unique(['session_id'], 'unique_session_cart');
            $table->index(['user_id', 'status']);
            $table->index(['last_activity_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
