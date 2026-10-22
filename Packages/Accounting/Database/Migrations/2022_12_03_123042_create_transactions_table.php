<?php

use Packages\Accounting\Models\Account;
use Packages\Accounting\Models\FinancialYear;
use Packages\Common\Models\Branch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable();
            $table->foreignIdFor(Branch::class)->nullable()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(FinancialYear::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(Account::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->morphs('transactionable');
            $table->decimal('amount', 18, 2);
            $table->decimal('balance_before', 18, 2);
            $table->decimal('balance_after', 18, 2);
            $table->string('notes')->nullable();
            $table->string('statement')->nullable();
            $table->string('transaction_type')->nullable(); // Enum
            $table->string('transaction_purpose')->nullable(); // Enum
            $table->string('transaction_source')->nullable(); // Enum
            $table->string('direction')->nullable(); // Enum
            $table->string('status')->default('pending'); // Enum
            $table->foreignId('related_transaction_id')->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('account_from_number')->nullable();
            $table->string('account_from_name')->nullable();
            $table->string('account_to_number')->nullable();
            $table->string('account_to_name')->nullable();
            $table->foreignId('academic_year')->nullable();
            $table->enum('type', ['debit', 'credit'])->nullable();
            $table->text('metadata')->nullable();
            $table->decimal('debit', 18, 2)->default(0);
            $table->decimal('credit', 18, 2)->default(0);
            $table->string('invoice_number')->nullable();
            $table->decimal('balance', 18, 2)->default(0);
            $table->string('exchange_rate')->nullable();
            $table->string('exchange_rate_notes')->nullable();
            ///////////////////////////////////////////
            $table->nullableMorphs('source_model');
            $table->nullableMorphs('direct_model');
            ///////////////////////////////////////////
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
