<?php

use Packages\Accounting\Models\UserPayment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_payment_items', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable();
            $table->foreignIdFor(UserPayment::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->unsignedBigInteger('service_invoice_item_id')->nullable();
            $table->decimal('amount', 16, 2)->nullable();
            $table->decimal('sub_total', 16, 2)->nullable();
            $table->decimal('net_total', 16, 2)->nullable();
            $table->integer('service_percentage')->nullable();
            $table->decimal('discount', 16, 2)->default(0);
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_payment_items');
    }
};
