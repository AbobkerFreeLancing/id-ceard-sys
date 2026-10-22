<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\Support\Models\TicketCategory;

return new class extends Migration {
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('admin_notes')->nullable();
            // (User, Student, Employee)
            $table->nullableMorphs('ticketable');
            $table->foreignIdFor(TicketCategory::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(User::class, 'assigned_to')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('assigned_at')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['open', 'in_progress', 'closed'])->default('open');
            $table->string('ticket_number')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamp('closed_at')->nullable();
            //
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
