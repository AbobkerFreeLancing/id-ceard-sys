<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idcard_reissues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('original_card_id')->constrained('idcard_cards')->onDelete('cascade');
            $table->foreignId('new_card_id')->nullable()->constrained('idcard_cards')->onDelete('set null');
            $table->string('reason', 50); // lost, damaged, info_change, expired, stolen
            $table->text('notes')->nullable();
            $table->decimal('fee_amount', 10, 2)->default(0.00);
            $table->boolean('is_paid')->default(false);
            $table->foreignId('requested_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status', 30)->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idcard_reissues');
    }
};
