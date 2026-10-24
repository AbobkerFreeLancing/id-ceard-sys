<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('card_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no', 50)->unique();
            $table->foreignId('template_id')->constrained('idcard_templates')->restrictOnDelete();
            $table->string('status', 20)->default('draft');
            $table->unsignedSmallInteger('cards_per_sheet')->default(8);
            $table->unsignedInteger('total_cards')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('printed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_batches');
    }
};
