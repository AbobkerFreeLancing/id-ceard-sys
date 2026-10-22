<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\Student;
use Packages\University\Models\Department;
use Packages\University\Models\Level;
use Packages\University\Models\AcademicYear;
use Packages\University\Models\College;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_university_id_cards', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(AcademicYear::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(College::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Department::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Level::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(User::class, 'created_by')->nullable()->constrained()->cascadeOnUpdate();
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->foreignIdFor(User::class, 'approved_by')->nullable()->constrained()->cascadeOnUpdate();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_university_id_cards');
    }
};
