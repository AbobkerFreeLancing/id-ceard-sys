<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\Accounting\Models\Bank;
use Packages\Accounting\Models\Currency;
use Packages\University\Models\College;
use Packages\University\Models\Invoice;
use Packages\University\Models\Level;
use Packages\University\Models\Semester;
use Packages\University\Models\Student;
use Packages\University\Models\AcademicYear;
use Packages\University\Models\StudentCharge;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable();
            $table->string('receipt_no')->nullable();
            $table
                ->foreignIdFor(StudentCharge::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignIdFor(Invoice::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Student::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(AcademicYear::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Semester::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Currency::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(College::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Level::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Bank::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(User::class, 'user_id')->nullable()->cascadeOnUpdate()->restrictOnDelete(); // Creator
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('attachment')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_distributed')->default(false);
            $table->boolean('is_cancelled')->default(false);
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
