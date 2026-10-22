<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\AcademicYear;
use Packages\University\Models\College;
use Packages\University\Models\Student;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_interviews', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable()->unique();
            $table->foreignIdFor(Student::class)->constrained();
            $table->foreignIdFor(AcademicYear::class)->nullable()->constrained();
            $table->foreignIdFor(College::class)->nullable()->constrained();
            $table->date('interview_date')->nullable();
            $table->string('interviewer_name')->nullable();
            $table->text('committee_members')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->string('status', 30)->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('conducted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('conducted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_interviews');
    }
};
