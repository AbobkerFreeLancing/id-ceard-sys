<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\Course;
use Packages\University\Models\Result;
use Packages\University\Models\Student;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('result_details', function (Blueprint $table) {
            $table->id();
            //كشف رصد درجات الطلاب التفصيلي لكل مادة على حدة وهو عصب السجل الأكاديمي والشهادة لبيان الدرجات والتقديرات الفردية';
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Result::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Course::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            // ::TODO:: Absence
            // $table->foreignIdFor(Absence::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('mark1', 7, 2)->nullable();
            $table->decimal('mark2', 7, 2)->nullable();
            $table->decimal('mid_term_mark', 7, 2)->nullable();
            $table->decimal('final_mark', 7, 2)->nullable();
            $table->decimal('total_mark', 7, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('result_details');
    }
};
