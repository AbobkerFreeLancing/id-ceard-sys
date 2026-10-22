<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('allocation_id')->nullable()->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('lecture_date')->nullable();
            $table->string('lecture_time', 50)->nullable();
            $table->string('topic', 255)->nullable();
            $table->string('lecturer', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
