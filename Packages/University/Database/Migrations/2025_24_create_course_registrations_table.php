<?php

use App\Models\State;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\Accounting\Models\Currency;
use Packages\University\Models\AcceptanceType;
use Packages\University\Models\College;
use Packages\University\Models\Course;
use Packages\University\Models\Department;
use Packages\University\Models\Level;
use Packages\University\Models\Semester;
use Packages\University\Models\Student;
use Packages\University\Models\AcademicYear;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_registrations', function (Blueprint $table) {
            $table->id();
            // المواد الفعالة التي سجلها الطالب في الفصل الحالي؛ وبناء عليها تظهر أسمائهم في رصد الكنترول'
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Course::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Semester::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(AcademicYear::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(AcceptanceType::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->date('registration_date');
            $table->enum('status', ['active', 'withdrawn'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_registrations');
    }
};
