<?php

use App\Models\State;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\Accounting\Models\Currency;
use Packages\University\Models\AcceptanceType;
use Packages\University\Models\Batch;
use Packages\University\Models\College;
use Packages\University\Models\Department;
use Packages\University\Models\Level;
use Packages\University\Models\Semester;
use Packages\University\Models\AcademicYear;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignIdFor(Currency::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(AcademicYear::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(College::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Department::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Level::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(State::class)->nullable();
            $table->foreignIdFor(Batch::class)->nullable();
            $table->foreignIdFor(Semester::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(AcceptanceType::class)->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->boolean('is_medical_checkup_structure')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->dateTime('approved_at')->nullable();
            $table->foreignIdFor(User::class, 'approved_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};
