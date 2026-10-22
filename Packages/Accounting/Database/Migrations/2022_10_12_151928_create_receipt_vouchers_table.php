<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('receipt_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable();
            $table->decimal('amount', 18, 2)->default(0);
            $table->foreignId('financial_year_id')->nullable()->constrained("financial_years")->cascadeOnUpdate()->nullOnDelete();
            $table->string('giver_name', 70)->nullable();
            $table->string('receiver_name', 70)->nullable();
            $table->date('receipt_date')->default(now());
            $table->foreignId('giver_account_id')->nullable()->constrained("accounts")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('receiver_account_id')->nullable()->constrained("accounts")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('payment_method_id')->nullable();
            $table->foreignId('currency_id')->nullable()->constrained("currencies")->cascadeOnUpdate()->nullOnDelete();
            $table->boolean('is_approved')->default(false);
            $table->string('notes', 250)->nullable();
            $table->foreignId('creator_id')->nullable()->constrained("users")->cascadeOnUpdate()->nullOnDelete();
            $table->string('cheque_number')->nullable();
            $table->string('cheque_bank_name')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('receipt_vouchers');
    }
};
