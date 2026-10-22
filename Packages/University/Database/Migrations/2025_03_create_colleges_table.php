<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Enums\CollegeProgramTypeEnum;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('code')->unique()->nullable();
            $table->string('code_male')->unique()->nullable();
            $table->string('code_female')->unique()->nullable();
            $table->string('final_level_id')->unique()->nullable();
            // 'bachelor', 'diploma', 'continuing', 'postgraduate'
            $table
                ->enum('program_type', array_column(CollegeProgramTypeEnum::cases(), 'value'))
                ->default(CollegeProgramTypeEnum::Bachelor->value);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colleges');
    }
};
