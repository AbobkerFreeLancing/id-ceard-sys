<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idcard_template_elements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_template_id')->constrained('idcard_templates')->onDelete('cascade');
            $table->enum('side', ['front', 'back'])->default('front');
            $table->string('element_key', 50); // photo, full_name, id_number, department, role, qr_code, barcode, expiry_date
            $table->string('label', 100)->nullable();
            $table->decimal('pos_x_mm', 6, 2)->default(0.00);
            $table->decimal('pos_y_mm', 6, 2)->default(0.00);
            $table->decimal('width_mm', 6, 2)->nullable();
            $table->decimal('height_mm', 6, 2)->nullable();
            $table->string('font_family', 50)->default('Almarai-Regular');
            $table->decimal('font_size_pt', 4, 1)->default(10.0);
            $table->string('font_weight', 20)->default('normal');
            $table->string('color_hex', 10)->default('#000000');
            $table->enum('text_align', ['left', 'center', 'right'])->default('center');
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idcard_template_elements');
    }
};
