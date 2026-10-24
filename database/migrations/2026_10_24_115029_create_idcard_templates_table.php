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
        Schema::create('idcard_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('idcard_organizations')->cascadeOnDelete();
            $table->string('name');
            $table->string('orientation', 20)->default('landscape');
            $table->decimal('width_mm', 8, 2)->default(85.60);
            $table->decimal('height_mm', 8, 2)->default(54.00);
            $table->unsignedSmallInteger('dpi')->default(300);
            $table->string('front_bg')->nullable();
            $table->string('back_bg')->nullable();
            $table->json('layout')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idcard_templates');
    }
};
