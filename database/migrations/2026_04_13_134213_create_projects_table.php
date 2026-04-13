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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->string('catIcon')->nullable();
            $table->text('desc')->nullable();
            $table->text('fullDesc')->nullable();
            $table->string('image')->nullable();
            $table->json('tags')->nullable();
            $table->string('year')->nullable();
            $table->string('type')->nullable();
            $table->integer('downloads')->default(0);
            $table->string('downloadUrl')->nullable();
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
