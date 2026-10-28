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
        Schema::table('idcard_cardholders', function (Blueprint $table) {
            $table->string('audit_status', 30)->default('approved')->after('signature_path');
            $table->text('audit_notes')->nullable()->after('audit_status');
            $table->foreignId('audited_by')->nullable()->constrained('users')->nullOnDelete()->after('audit_notes');

            $table->index('audit_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('idcard_cardholders', function (Blueprint $table) {
            $table->dropForeign(['audited_by']);
            $table->dropColumn(['audit_status', 'audit_notes', 'audited_by']);
        });
    }
};
