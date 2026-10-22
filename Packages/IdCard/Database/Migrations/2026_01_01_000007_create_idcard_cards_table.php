<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idcard_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cardholder_id')->constrained('idcard_cardholders')->onDelete('cascade');
            $table->foreignId('card_template_id')->constrained('idcard_templates');
            $table->foreignId('batch_id')->nullable()->constrained('idcard_batches')->onDelete('set null');
            $table->string('card_uid', 64)->unique();
            $table->string('card_number', 30)->unique();
            $table->string('rfid_chip_code', 50)->nullable();
            $table->string('barcode_value', 50);
            $table->string('qr_token', 255)->unique();
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->string('status', 30)->default('draft');
            $table->unsignedInteger('print_count')->default(0);
            $table->timestamp('last_printed_at')->nullable();
            $table->string('reissue_reason', 255)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('status');
            $table->index('card_uid');
            $table->index('qr_token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idcard_cards');
    }
};
