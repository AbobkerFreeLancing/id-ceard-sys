<?php

use Packages\Accounting\Models\FinancialYear;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('account_balance_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FinancialYear::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->decimal('amount', 16, 2);
            $table->foreignId('account_from_id')->constrained('accounts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('account_to_id')->constrained('accounts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('is_approved')->default(false);
            $table->decimal('acc_from_exchange_rate', 15, 5)->default(0);
            $table->decimal('acc_to_exchange_rate', 15, 5)->default(0);
            $table->string('description')->nullable();
            $table->foreignId('creator_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('account_balance_transfers');
    }
};
