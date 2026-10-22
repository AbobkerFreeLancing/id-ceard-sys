<?php

use App\Models\User;
use Packages\Common\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table
                ->foreignIdFor(Country::class, 'nationality_country_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table
                ->foreignIdFor(Country::class, 'residence_country_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table
                ->foreignIdFor(Country::class, 'residence_city_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('children_count')->nullable();
            $table->unsignedSmallInteger('min_age')->nullable();
            $table->unsignedSmallInteger('max_age')->nullable();
            $table->unsignedSmallInteger('min_height')->nullable();
            $table->unsignedSmallInteger('max_height')->nullable();
            $table->string('work_field')->nullable();
            $table->string('religiosity_level')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('education_level')->nullable();
            $table->string('income_range')->nullable();
            $table->string('body_shape')->nullable();
            $table->string('tribe')->nullable();
            $table->boolean('wants_children')->nullable();
            $table->unsignedSmallInteger('distance_km')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('preferences');
    }
};
