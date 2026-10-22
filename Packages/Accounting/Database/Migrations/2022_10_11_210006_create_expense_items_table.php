<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expense_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 18, 2)->default(0);
            $table->integer('qty')->default(1);
            $table->foreignId('expense_id')->constrained("expenses")->cascadeOnUpdate()->CascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expense_items');
    }
};
