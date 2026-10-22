<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dev_settings', function (Blueprint $table) {
            $table->id();
            $table->string('admin_logo')->nullable();
            $table->string('invoice_logo')->nullable();
            $table->string('invoice_logo_height')->nullable();
            $table->text('content')->nullable();
            $table->unsignedInteger('logo_height')->nullable();
            $table->string('admin_color_hex', 15)->default('#00a6f4');
            $table->boolean('on_demo_mode')->default(true);
            $table->string('website_favicon')->nullable();
            $table->string('admin_favicon')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dev_settings');
    }
};
