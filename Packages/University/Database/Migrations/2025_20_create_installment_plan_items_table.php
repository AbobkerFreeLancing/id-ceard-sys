<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('installment_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installment_plan_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('installment_number');
            $table->string('name');
            $table->decimal('percentage', 7, 4)->nullable();
            $table->decimal('fixed_amount', 14, 2)->nullable();
            $table->unsignedSmallInteger('due_after_days')->default(0);
            $table->date('fixed_due_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installment_plan_items');
    }
};
