<?php

use App\Models\State;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\Course;
use Packages\University\Models\Department;
use Packages\University\Models\Level;
use Packages\University\Models\Semester;
use Packages\University\Models\AcademicYear;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Course::class);
            $table->foreignIdFor(Department::class);
            $table->foreignIdFor(Level::class);
            $table->foreignIdFor(State::class);
            $table->foreignIdFor(Semester::class);
            $table->foreignIdFor(AcademicYear::class);
            $table->string('course_order')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_allocations');
    }
};
