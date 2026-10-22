<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cost_centers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('slug')->nullable();
            $table->string('code')->unique()->nullable();
            $table->enum('level_type', ['group', 'sub'])->nullable();
            $table->enum('type', ['debit', 'credit'])->nullable();
            $table->decimal('balance', 16, 2)->default(0);
            $table->foreignId('currency_id')->nullable()->cascadeOnUpdate()->nullOnDelete();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->decimal('debit', 16, 2)->default(0);
            $table->decimal('credit', 16, 2)->default(0);
            $table->decimal('start_balance', 16, 2)->default(0);
            $table->foreignId('creator_id')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_editable')->default(true);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cost_centers');
    }
};
