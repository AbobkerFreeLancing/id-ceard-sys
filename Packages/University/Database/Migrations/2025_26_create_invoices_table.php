<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\Accounting\Models\Bank;
use Packages\Accounting\Models\Currency;
use Packages\University\Models\College;
use Packages\University\Models\Level;
use Packages\University\Models\Semester;
use Packages\University\Models\Student;
use Packages\University\Models\AcademicYear;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(AcademicYear::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Semester::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(College::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Level::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Bank::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(User::class, 'user_id')->nullable()->constrained()->cascadeOnUpdate(); // Creator
            $table->foreignIdFor(Currency::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('discount', 15, 2)->default(0.0);
            $table->decimal('total', 15, 2)->default(0.0);
            $table->decimal('net_total', 15, 2)->default(0.0);
            $table->text('notes')->nullable();
            $table->enum('payment_status', ['unpaid', 'partially_paid', 'paid'])->default('unpaid');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
