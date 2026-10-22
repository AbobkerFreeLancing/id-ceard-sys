<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grade_scales', function (Blueprint $table) {
            $table->id();
            $table->string('grade');
            $table->string('grade_en')->nullable();
            $table->unsignedInteger('min_mark')->nullable();
            $table->unsignedInteger('max_mark')->nullable();
            $table->decimal('points', 5, 2)->nullable();
            $table->string('estimation_ar')->nullable();
            $table->string('estimation_en')->nullable();
            $table->boolean('is_pass')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_scales');
    }
};
