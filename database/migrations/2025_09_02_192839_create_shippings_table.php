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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('carrier')->nullable();     // e.g., DHL, FedEx
            $table->string('service')->nullable();     // e.g., Express, Ground
            $table->string('tracking_number')->nullable()->index();
            $table->enum('status', [
                'pending', 'label_printed', 'shipped', 'in_transit', 'delivered', 'returned',
            ])->default('pending')->index();
            $table->decimal('cost', 12, 2)->default(0);
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->json('meta')->nullable(); // label data, package dims, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
