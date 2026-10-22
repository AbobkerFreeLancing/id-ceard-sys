<?php

use App\Models\User;
use Packages\University\Models\College;
use Packages\University\Models\Department;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\AcademicYear;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable();
            $table->foreignIdFor(College::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Department::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(AcademicYear::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name'); // مثال: دفعة 2022
            $table->string('name_en')->nullable();
            $table->string('code')->nullable();
            $table->string('batch_year', 4)->nullable();
            $table->string('graduation_year', 4)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('has_graduated')->default(false);
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
