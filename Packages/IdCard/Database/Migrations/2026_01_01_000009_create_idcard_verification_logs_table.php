<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idcard_verification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->nullable()->constrained('idcard_cards')->onDelete('set null');
            $table->string('scanned_token', 255);
            $table->foreignId('verifier_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('verification_status', 30);
            $table->string('scanner_ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_type', 50)->nullable();
            $table->decimal('location_latitude', 10, 8)->nullable();
            $table->decimal('location_longitude', 11, 8)->nullable();
            $table->timestamp('scanned_at')->useCurrent();

            $table->index('scanned_at');
            $table->index('verification_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idcard_verification_logs');
    }
};
