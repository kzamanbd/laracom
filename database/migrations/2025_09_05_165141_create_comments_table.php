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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // Polymorphic relation
            $table->morphs('model'); // model_type, model_id

            // Nested comments (self-reference)
            $table->unsignedBigInteger('parent_id')->nullable()->index();

            // User or guest
            $table->foreignId('user_id')->nullable()->index();
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();

            // Content
            $table->text('comment');
            $table->unsignedTinyInteger('rating')->nullable(); // Only for products

            // Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();

            // Indexes for polymorphic relation
            $table->index(['model', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
