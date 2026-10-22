<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\Common\Models\Country;
use Packages\University\Enums\GuardianRelationshipEnum;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('university_no')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->boolean('is_active')->default(true);
            // ----------
            $table->string('full_name')->nullable();
            $table->string('full_name_en')->nullable();
            $table->foreignIdFor(Country::class, 'nationality_id')->nullable()->constrained();
            // ----------
            $table->string('first_name')->nullable();
            $table->string('first_name_en')->nullable();
            // ----------
            $table->string('second_name')->nullable();
            $table->string('second_name_en')->nullable();
            // ----------
            $table->string('third_name')->nullable();
            $table->string('third_name_en')->nullable();
            // ----------
            $table->string('fourth_name')->nullable();
            $table->string('fourth_name_en')->nullable();
            // ----------
            $table->string('guardian_name', 50)->nullable();
            $table->string('guardian_phone', 30)->nullable();
            $table->enum('guardian_relationship', array_column(GuardianRelationshipEnum::cases(), 'value'))->nullable();
            $table->string('guardian_job')->nullable();
            // ----------
            $table->string('address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('profile_picture')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('graduation_date')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('passport_no')->nullable();
            $table->string('national_id_number',20)->nullable();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
