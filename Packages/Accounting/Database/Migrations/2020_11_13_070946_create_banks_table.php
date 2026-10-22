<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('name_en')->nullable();
            $table->string('code')->nullable();
            $table->string('api_key')->nullable();
            $table->integer('sort_order')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_active')->default(true);
            $table->string('swift_number')->nullable();
            $table->string('website_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banks');
    }
};
