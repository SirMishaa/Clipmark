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
        Schema::create('article_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->longText('content');
            $table->string('content_hash', 64);
            $table->string('title', 500);
            $table->string('author', 255)->nullable();
            $table->integer('reading_time')->nullable();
            $table->integer('word_count')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('fetched_at');
            $table->timestamps();

            $table->index('article_id');
            $table->index('content_hash');
            $table->index('fetched_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_versions');
    }
};
