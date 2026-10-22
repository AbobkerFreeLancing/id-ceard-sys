<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\Accounting\Models\Currency;
use Packages\University\Models\Student;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_charges', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number', 70)->nullable()->unique();
            $table->foreignIdFor(Currency::class)->nullable()->constrained();
            $table->foreignIdFor(Student::class)->nullable()->constrained();
            $table->foreignId('fee_type_id')->constrained()->restrictOnDelete();
            $table->foreignId('fee_structure_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('fee_structure_item_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->nullOnDelete();
            $table->foreignId('semester_id')->nullable()->constrained('semesters')->nullOnDelete();
            $table->string('description')->nullable();
            $table->decimal('gross_amount', 14, 2);
            $table->decimal('discount_amount', 14, 2)->default(0);
            $table->decimal('net_amount', 14, 2);
            $table->date('due_date')->nullable();
            $table->string('status', 24)->default('unpaid'); // PaymentStatusEnum
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_charges');
    }
};
