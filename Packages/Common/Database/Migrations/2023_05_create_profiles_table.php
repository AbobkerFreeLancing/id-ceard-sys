<?php

use App\Models\User;
use Packages\Common\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
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
            $table->string('marital_status', 40)->nullable();
            $table->unsignedTinyInteger('children_count')->default(0);
            $table->string('education_level')->nullable();
            $table->string('work_field')->nullable();
            $table->string('job_title')->nullable();
            $table->string('income_range')->nullable();
            $table->unsignedSmallInteger('height')->nullable();
            $table->unsignedSmallInteger('weight')->nullable();
            $table->string('skin_color')->nullable();
            $table->string('body_shape')->nullable();
            $table->string('religiosity_level')->nullable();
            $table->string('tribe')->nullable();
            $table->boolean('smoking')->default(false);
            $table->boolean('profile_completed')->default(false);
            $table->boolean('show_photo')->default(true);
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
