<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->default('settings-page');
            $table->string('company_name')->default('Company Name');
            $table->string('company_address')->nullable();
            $table->string('company_phones')->nullable();
            $table->string('company_email')->nullable();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('invoice_tagline')->nullable();
            $table->string('invoice_logo')->nullable();
            $table->foreignId('currency_id')->nullable();
            /////////////////////////////////
            $table->boolean('pause_api_login')->default(false);
            $table->boolean('pause_api_register')->default(false);
            /////////////////////////////////
            $table->foreignId('financial_year_id')->nullable();
            $table->boolean('must_approve_sales_invoice')->default(true);
            $table->foreignId('sales_default_currency_id')->nullable();
            $table->foreignId('sales_default_account_id')->nullable();
            $table->foreignId('sales_default_customer_id')->nullable();
            $table->foreignId('sales_default_warehouse_account_id')->nullable();
            $table->foreignId('sale_returns_default_account_id')->nullable();
            $table->foreignId('purchases_default_account_id')->nullable();
            $table->foreignId('purchase_returns_default_account_id')->nullable();
            $table->unsignedInteger('alert_expire_days_count')->default(30);
            $table->foreignId('academic_year_id')->nullable();
            /////////////////////////////////
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
