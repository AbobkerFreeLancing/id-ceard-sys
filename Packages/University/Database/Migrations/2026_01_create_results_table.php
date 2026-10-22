<?php

use App\Models\State;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\Batch;
use Packages\University\Models\Department;
use Packages\University\Models\Level;
use Packages\University\Models\ResultType;
use Packages\University\Models\Semester;
use Packages\University\Models\AcademicYear;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Batch::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(AcademicYear::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Semester::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(State::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Department::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Level::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(ResultType::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('status', 30)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
