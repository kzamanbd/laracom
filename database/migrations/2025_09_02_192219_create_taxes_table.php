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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('rate', 8, 4); // e.g., 0.1500 = 15%
            $table->boolean('inclusive')->default(false); // price includes tax?
            // scope (nullable = global)
            $table->string('country', 2)->nullable()->index();
            $table->string('state')->nullable()->index();
            $table->string('postal_code')->nullable()->index();
            $table->unsignedInteger('priority')->default(1); // for compounding/multiple rules
            $table->boolean('compound')->default(false);
            $table->boolean('enabled')->default(true)->index();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};
