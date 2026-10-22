<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\University\Models\Result;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('result_archives', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Result::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('file_path');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table
                ->foreignIdFor(User::class, 'created_by_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('result_archives');
    }
};
