<?php

use Packages\Support\Models\Ticket;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('ticket_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ticket::class)->nullable();
            $table->nullableMorphs('repliable');
            $table->text('reply');
            $table->string('attachment')->nullable();
            $table->boolean('is_internal_note')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_replies');
    }
};
