<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\FeeStructure;
use Packages\University\Models\FeeType;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fee_structure_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FeeStructure::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(FeeType::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('amount', 15, 2)->default(0);
            $table->boolean('is_mandatory')->default(false);
            $table->boolean('installment_eligible')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_structure_items');
    }
};
