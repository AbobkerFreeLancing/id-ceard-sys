<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Enums\IdentityTypeEnum;
use Packages\University\Models\Student;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_identities', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable();
            $table->foreignIdFor(Student::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class, 'approved_by')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->enum('type', array_column(IdentityTypeEnum::cases(), 'value'))->index();
            $table->string('number')->nullable();
            $table->string('issuing_authority')->nullable(); // جهة الإصدار
            $table->string('issuing_country')->nullable(); // بلد الإصدار
            $table->date('issue_date')->nullable(); // تاريخ الإصدار
            $table->date('expiry_date')->nullable(); // تاريخ الانتهاء
            $table->string('attachment')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_identities');
    }
};
