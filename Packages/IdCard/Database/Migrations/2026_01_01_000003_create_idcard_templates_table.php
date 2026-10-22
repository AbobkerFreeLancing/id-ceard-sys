<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idcard_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained('idcard_organizations')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('card_type', 50)->default('employee');
            $table->string('orientation', 20)->default('landscape');
            $table->decimal('width_mm', 6, 2)->default(85.60);
            $table->decimal('height_mm', 6, 2)->default(53.98);
            $table->string('front_background_image', 255)->nullable();
            $table->string('back_background_image', 255)->nullable();
            $table->json('design_config_json')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idcard_templates');
    }
};
