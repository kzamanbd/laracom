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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->morphs('model'); // model_type, model_id
            $table->string('collection')->default('default')->index(); // e.g. "images", "documents"
            $table->string('disk')->default('public'); // storage disk
            $table->string('directory')->nullable();
            $table->string('filename');
            $table->string('extension', 16)->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size_bytes')->default(0);
            $table->string('path')->index(); // full relative path
            $table->string('alt')->nullable();
            $table->unsignedInteger('order_column')->default(0)->index();
            $table->json('meta')->nullable(); // custom metadata
            $table->timestamps();

            $table->index(['model_type', 'model_id', 'collection']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
