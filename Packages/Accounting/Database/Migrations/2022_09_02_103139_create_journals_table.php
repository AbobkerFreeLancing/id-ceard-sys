<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable();
            $table->string('statement',200)->nullable();
            $table->foreignId('financial_year_id')->nullable()->constrained("financial_years")->cascadeOnUpdate()->nullOnDelete();
            $table->date('the_date')->nullable();
            $table->decimal('total', 18, 2)->nullable();
            $table->decimal('debit_total', 18, 2)->nullable();
            $table->decimal('credit_total', 18, 2)->nullable();
            $table->boolean('is_approved')->default(false);
            $table->foreignId('creator_id')->nullable();
            $table->string('exchange_rate_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('journals');
    }
};
