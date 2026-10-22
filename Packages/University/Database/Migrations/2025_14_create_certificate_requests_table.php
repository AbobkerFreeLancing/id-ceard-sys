<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\CertificateType;
use Packages\University\Models\Student;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('certificate_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(User::class)->nullable()->comment('الموظف الذي قام بالطباعة أو الاعتماد');
            $table->foreignIdFor(CertificateType::class)->nullable();
            $table->string('serial_no')->nullable();
            $table->string('certificate_language')->nullable();
            $table->boolean('is_dual')->nullable()->comment('شهادة مزدوجة (عربي/إنجليزي)');
            $table
                ->boolean('registrar_approval')
                ->default(false)
                ->nullable()
                ->comment('اعتماد مسجل الكلية للشيت الأكاديمي,');
            $table
                ->boolean('financial_clearance')
                ->default(false)
                ->nullable()
                ->comment('حالة براءة الذمة المالية من الحسابات');
            $table->date('issue_date')->nullable()->comment('تاريخ إصدار وتسليم الوثيقة للطالب');
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'printed', 'rejected'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_requests');
    }
};
