<?php

use App\Models\User;
use Packages\Enum\PriorityEnum;
use Packages\Enum\NoteStatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->enum('priority', array_column(PriorityEnum::cases(), 'value'))->default(PriorityEnum::Medium->value);
            $table->enum('status', array_column(NoteStatusEnum::cases(), 'value'))->default(NoteStatusEnum::Todo->value);
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
