<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('chat_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('chat_conversations')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('member');
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('left_at')->nullable();
            $table->timestamp('last_read_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->boolean('can_send_messages')->default(true);
            $table->boolean('can_add_participants')->default(false);
            $table->boolean('is_muted')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_blocked')->default(false);
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->unique(['conversation_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_participants');
    }
};
