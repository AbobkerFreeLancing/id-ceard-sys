<?php

use App\Models\User;
use Packages\Accounting\Models\FinancialYear;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_payments', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable();
            $table->foreignIdFor(FinancialYear::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('type')->nullable();
            $table
                ->foreignId('account_from_id')
                ->nullable()
                ->constrained('accounts')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreignId('account_to_id')
                ->nullable()
                ->constrained('accounts')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->boolean('is_approved')->default(false);
            $table->decimal('amount', 16, 2);
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_payments');
    }
};
