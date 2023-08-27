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
        Schema::create('latest_news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('group');
            $table->text('description');
            $table->string('image');
            $table->string('docs')->nullable();
            $table->date('date')->nullable();
            $table->string('ar_title')->nullable();
            $table->string('ar_group')->nullable();
            $table->text('ar_description')->nullable();
            $table->string('pe_title')->nullable();
            $table->string('pe_group')->nullable();
            $table->text('pe_description')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('latest_news');
    }
};
