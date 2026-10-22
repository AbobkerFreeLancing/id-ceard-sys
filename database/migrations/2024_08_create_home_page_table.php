<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_page', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Home');
            $table->string('slug')->default('home_page');
            $table->string('categories_title')->default('تسوق حسب الفئة');
            $table->string('categories_subtitle')->default('أكثر من فئة لتختر من بينها، لا حدود للخيارات!');
            // SEO fields
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_image')->nullable();
            // End SEO fields
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_page');
    }
};
