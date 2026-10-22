<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\AcademicStatus;
use Packages\University\Models\AcademicYear;
use Packages\University\Models\AcceptanceType;
use Packages\University\Models\Batch;
use Packages\University\Models\College;
use Packages\University\Models\Department;
use Packages\University\Models\Level;
use Packages\University\Models\Student;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('academic_records', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AcademicYear::class)->nullable()->constrained();
            $table->foreignIdFor(AcademicStatus::class)->nullable()->constrained();
            $table->foreignIdFor(Student::class)->constrained();
            $table->foreignIdFor(College::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Department::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(AcceptanceType::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Level::class)->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(Batch::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
            $table->unique(['student_id', 'academic_year_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_records');
    }
};
