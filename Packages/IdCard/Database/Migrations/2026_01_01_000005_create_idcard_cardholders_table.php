<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idcard_cardholders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained('idcard_organizations')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained('idcard_departments')->onDelete('set null');
            $table->string('first_name', 80);
            $table->string('last_name', 80);
            $table->string('full_name_ar', 160);
            $table->string('full_name_en', 160)->nullable();
            $table->string('national_id', 30)->unique();
            $table->string('identifier_code', 50)->unique(); // Academic/Employee ID
            $table->string('email', 100)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('blood_type', 5)->nullable();
            $table->string('job_title', 100)->nullable();
            $table->string('photo_path', 255)->nullable();
            $table->string('processed_photo_path', 255)->nullable();
            $table->string('signature_path', 255)->nullable();
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idcard_cardholders');
    }
};
