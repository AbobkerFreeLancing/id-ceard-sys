<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\Batch;
use Packages\University\Models\Course;
use Packages\University\Models\Level;
use Packages\University\Models\Semester;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('batch_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Batch::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Course::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Semester::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Level::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batch_courses');
    }
};
