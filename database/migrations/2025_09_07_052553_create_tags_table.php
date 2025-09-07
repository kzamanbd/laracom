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
        // Tags table
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();  // Tag name (e.g. "Laravel", "Electronics")
            $table->string('slug')->unique();  // URL-friendly version
            $table->timestamps();
        });

        // Polymorphic pivot table
        Schema::create('taggables', function (Blueprint $table) {
            $table->morphs('taggable'); // taggable_type, taggable_id
            $table->foreignId('tag_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('taggables');
    }
};
