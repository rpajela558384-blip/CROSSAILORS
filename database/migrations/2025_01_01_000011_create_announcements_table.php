<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'text']);
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('image_path')->nullable();
            $table->enum('category', ['announcement', 'schedule']);
            $table->boolean('active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
