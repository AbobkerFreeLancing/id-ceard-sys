<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idcard_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number', 50)->unique();
            $table->foreignId('card_template_id')->constrained('idcard_templates');
            $table->unsignedInteger('total_cards')->default(0);
            $table->enum('output_format', ['a4_sheet', 'cr80_single_pdf', 'zip_images'])->default('a4_sheet');
            $table->string('pdf_file_path', 255)->nullable();
            $table->enum('status', ['pending', 'generated', 'printed', 'cancelled'])->default('pending');
            $table->foreignId('generated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idcard_batches');
    }
};
