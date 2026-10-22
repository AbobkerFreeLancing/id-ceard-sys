<?php

use Packages\Common\Models\Branch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable();
            $table->foreignIdFor(Branch::class)->nullable()->cascadeOnUpdate()->nullOnDelete();
            $table->decimal('amount', 18, 2)->default(0);
            $table
                ->foreignId('financial_year_id')
                ->nullable()
                ->constrained('financial_years')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('receiver_name', 50)->nullable();
            $table->boolean('is_approved')->default(false);
            $table->date('expense_date')->default(now());
            $table->string('attachment')->nullable();
            $table->foreignId('payment_method_id')->nullable();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('account_id')->nullable()->constrained('accounts')->cascadeOnUpdate()->nullOnDelete();
            $table
                ->foreignId('payment_account_id')
                ->nullable()
                ->constrained('accounts')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('creator_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('cheque_number')->nullable();
            $table->string('cheque_bank_name')->nullable();
            $table->string('notes', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
