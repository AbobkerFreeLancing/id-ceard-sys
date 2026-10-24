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
        Schema::create('idcard_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('idcard_organizations')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('idcard_departments')->nullOnDelete();
            $table->string('type')->nullable();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('path')->nullable();
            $table->unsignedInteger('depth')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('path');
            $table->index(['organization_id', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idcard_departments');
    }
};
