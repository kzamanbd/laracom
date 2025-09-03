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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('provider')->index(); // e.g., stripe, braintree, sslcommerz
            $table->string('reference')->nullable()->index(); // gateway txn id
            $table->decimal('amount', 14, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['initiated','succeeded','failed','refunded','partially_refunded'])->index();
            $table->json('payload')->nullable(); // gateway response snapshot
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
