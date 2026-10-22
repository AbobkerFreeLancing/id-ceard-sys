<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\Batch;
use Packages\University\Models\College;
use Packages\University\Models\Department;
use Packages\University\Models\Division;
use Packages\University\Models\FeeStructure;
use Packages\University\Models\Invoice;
use Packages\University\Models\Level;
use Packages\University\Models\Semester;
use Packages\University\Models\Student;
use Packages\University\Models\AcademicYear;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Batch::class, 'from_batch_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Batch::class, 'to_batch_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table
                ->foreignIdFor(College::class, 'from_college_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignIdFor(College::class, 'to_college_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table
                ->foreignIdFor(Department::class, 'from_department_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table
                ->foreignIdFor(Department::class, 'to_department_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table
                ->foreignIdFor(Division::class, 'from_division_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table
                ->foreignIdFor(Division::class, 'to_division_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignIdFor(Level::class, 'from_level_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Level::class, 'to_level_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table
                ->foreignIdFor(AcademicYear::class, 'from_academic_year_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table
                ->foreignIdFor(AcademicYear::class, 'to_academic_year_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table
                ->foreignIdFor(Semester::class, 'from_semester_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table
                ->foreignIdFor(Semester::class, 'to_semester_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table
                ->foreignIdFor(FeeStructure::class, 'from_fee_structure_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table
                ->foreignIdFor(FeeStructure::class, 'to_fee_structure_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignIdFor(User::class, 'created_by')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(User::class, 'approved_by')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table
                ->enum('transfer_type', [
                    'batch_change',
                    'college_change',
                    'department_change',
                    'level_change',
                    'full_transfer',
                ])
                ->default('batch_change');
            $table
                ->enum('invoice_action', ['keep_old', 'cancel_old', 'replace_old', 'no_invoice'])
                ->default('replace_old');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table
                ->foreignIdFor(Invoice::class, 'old_invoice_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table
                ->foreignIdFor(Invoice::class, 'new_invoice_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->date('transfer_date')->nullable();
            $table->date('effective_date')->nullable();
            $table->decimal('old_fees_total', 15, 2)->default(0);
            $table->decimal('new_fees_total', 15, 2)->default(0);
            $table->decimal('fees_difference', 15, 2)->default(0);
            $table->decimal('paid_before_transfer', 15, 2)->default(0);
            $table->decimal('remaining_after_transfer', 15, 2)->default(0);
            $table->text('reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_transfers');
    }
};
