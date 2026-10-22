<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\Result;
use Packages\University\Models\Student;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Result::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('gpa', 5, 2)->nullable();
            $table->decimal('total_points', 8, 2)->nullable();
            $table->decimal('total_points_excluding_fails', 8, 2)->nullable();
            $table->decimal('credit_hours', 5, 2)->nullable();
            $table->string('status', 30)->nullable();
            $table->string('result_status', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_results');
    }
};
