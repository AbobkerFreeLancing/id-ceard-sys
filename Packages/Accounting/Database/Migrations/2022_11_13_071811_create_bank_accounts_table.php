<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('account_number')->nullable();
            $table->string('account_owner')->nullable();
            $table->string('code')->nullable();
            $table->decimal('start_balance', 15, 3)->default(0);
            $table->decimal('balance', 15, 3)->default(0);
            $table->boolean('is_enabled')->default(true);
            $table->foreignId('bank_id')->nullable()->constrained("banks")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained("currencies")->cascadeOnUpdate()->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
};
