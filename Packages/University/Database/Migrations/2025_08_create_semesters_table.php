<?php

use Packages\University\Models\AcademicYear;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AcademicYear::class)->nullable()->constrained();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->integer('sort_order')->nullable();
            $table->unsignedBigInteger('next_semester_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
