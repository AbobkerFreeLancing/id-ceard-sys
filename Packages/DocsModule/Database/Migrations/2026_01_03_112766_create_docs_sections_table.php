<?php

use Packages\DocsModule\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('docs_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class)->constrained('docs_projects')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('title');
            $table->string('menu_title')->nullable();
            $table->string('order_column')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('docs_sections');
    }
};
