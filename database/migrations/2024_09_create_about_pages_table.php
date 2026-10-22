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
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default("About us");
            $table->string('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->string('slug')->default("about_page");
            $table->json('content')->nullable();
             // SEO fields
             $table->string('meta_title')->nullable();
             $table->string('meta_description')->nullable();
             $table->string('meta_keywords')->nullable();
             $table->string('meta_image')->nullable();
             // End SEO fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
