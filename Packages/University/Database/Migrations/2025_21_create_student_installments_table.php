<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->restrictOnDelete();
            $table->foreignId('student_charge_id')->constrained()->cascadeOnDelete();
            $table->foreignId('installment_plan_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('installment_plan_item_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedSmallInteger('installment_number');
            $table->string('description')->nullable();
            $table->char('currency', 3)->default('SDG');
            $table->decimal('amount_due', 14, 2);
            $table->date('due_date');
            $table->string('status', 24)->default('pending'); // pending, partially_paid, paid, overdue, deferred, cancelled
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_installments');
    }
};
