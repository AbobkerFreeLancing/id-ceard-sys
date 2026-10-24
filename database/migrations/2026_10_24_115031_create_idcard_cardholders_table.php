<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('idcard_cardholders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('idcard_organizations')->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('idcard_departments')->nullOnDelete();
            $table->string('full_name_ar');
            $table->string('full_name_en');
            $table->string('national_id', 50)->unique();
            $table->string('employee_no', 50)->nullable();
            $table->string('blood_type', 10)->nullable();
            $table->string('photo_path')->nullable();
            $table->string('signature_path')->nullable();
            $table->json('extra_data')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['organization_id', 'department_id']);
            $table->index('employee_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idcard_cardholders');
    }
};
