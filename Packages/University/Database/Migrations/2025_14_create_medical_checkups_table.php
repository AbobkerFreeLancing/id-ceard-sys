<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\AcademicYear;
use Packages\University\Models\College;
use Packages\University\Models\Semester;
use Packages\University\Models\Student;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medical_checkups', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable()->unique();
            $table->foreignIdFor(Student::class)->constrained();
            $table->foreignIdFor(AcademicYear::class)->nullable()->constrained();
            $table->foreignIdFor(College::class)->nullable()->constrained();
            $table->foreignIdFor(Semester::class)->nullable()->constrained();
            ///////////////
            $table->date('checkup_date')->nullable();
            $table->string('medical_center')->nullable();
            $table->string('doctor_name')->nullable();

            // القياسات الحيوية الأساسية
            $table->string('blood_group', 10)->nullable();
            $table->string('blood_pressure', 40)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();

            // فحص الحواس والفحوصات السريرية العامة
            $table->string('vision_status')->nullable(); // حالة النظر (سليم، ضعف نظر...)
            $table->string('hearing_status')->nullable(); // حالة السمع

            // الأمراض والحساسية
            $table->boolean('has_chronic_diseases')->default(false); // هل توجد أمراض مزمنة؟
            $table->text('chronic_diseases_notes')->nullable(); // تفاصيل الأمراض المزمنة
            $table->text('allergies_notes')->nullable(); // أي حساسية أدوية أو طعام
            $table->boolean('has_past_surgeries')->default(false); // هل أجرى عمليات جراحية سابقة؟
            $table->text('surgeries_notes')->nullable();
            $table->text('general_notes')->nullable();

            // حالات الكشف والاعتماد
            $table->string('status', 30)->default('pending'); // pending, fit, unfit, under_review
            $table->boolean('is_cleared')->default(false); // هل منح الإجازة الطبية النهائية للتسجيل؟

            // الاعتماد والتدقيق
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_checkups');
    }
};
