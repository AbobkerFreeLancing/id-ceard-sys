<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('privacy_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default("Privacy Policy Page");
            $table->string('slug')->default("privacy_policy_page");
            $table->longText('content')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('privacy_pages');
    }
};
