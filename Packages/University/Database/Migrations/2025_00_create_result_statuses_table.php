<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('result_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_description', 50)->nullable();
            $table->string('slug')->nullable();
            $table->string('name_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('result_statuses');
    }
};
