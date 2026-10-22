<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('part_name')->nullable(); // Piaster / Halla /  ..etc
            $table->string('symbol')->nullable(); // SDG / USD / KWD ..etc
            $table->decimal('exchange_rate', 12, 5)->default(1);
            $table->decimal('reverse_exchange_rate', 12, 5)->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('currencies');
    }
};
