<?php

use Packages\DocsModule\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('docs_project_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Section::class)->constrained('docs_sections')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('title');
            $table->string('endpoint')->nullable();
            $table->string('request_method')->nullable();
            $table->string('menu_title')->nullable();
            $table->string('order_column')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('docs_project_items');
    }
};
