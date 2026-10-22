<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idcard_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained('idcard_organizations')->onDelete('cascade');
            
            // شبكية وقابلة للتمدد الذاتي (Self-referencing Nested Tree)
            $table->foreignId('parent_id')->nullable()->constrained('idcard_departments')->onDelete('cascade');

            $table->string('name', 150);                          // اسم القسم أو التصنيف
            $table->string('code', 50)->nullable();                // كود التصنيف
            $table->string('classification', 50)->default('department'); // نوع التصنيف: sector, division, department, unit, team, category, group
            $table->unsignedInteger('depth_level')->default(0);    // مستوى العمق الشجري (0: رئيسي، 1: فرعي، 2: تحت فرعي...)
            $table->unsignedInteger('order_column')->default(0);   // ترتيب العرض
            $table->string('color_hex', 10)->default('#00a6f4');  // لون مميز للبطاقات والشاشات
            $table->json('metadata_json')->nullable();             // خصائص وسمات إضافية ديناميكية
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // فهارس لتحسين سرعة الاستعلامات الشجرية والتصنيفات
            $table->index('parent_id');
            $table->index('classification');
            $table->index('depth_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idcard_departments');
    }
};
