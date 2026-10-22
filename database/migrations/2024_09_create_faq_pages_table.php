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
        Schema::create('faq_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default("FAQs");
            $table->string('subtitle')->nullable();
            $table->string('slug')->default("faq_page");
            $table->longText('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_pages');
    }
};
