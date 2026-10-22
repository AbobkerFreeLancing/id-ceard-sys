<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\Invoice;
use Packages\University\Models\StudentCharge;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Invoice::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(StudentCharge::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('discount', 15, 2)->default(0.0);
            $table->decimal('amount', 15, 2)->default(0.0);
            $table->decimal('net_amount', 15, 2)->default(0.0);
            $table->text('notes')->nullable();
            $table->enum('payment_status', ['unpaid', 'partially_paid', 'paid'])->default('unpaid');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
