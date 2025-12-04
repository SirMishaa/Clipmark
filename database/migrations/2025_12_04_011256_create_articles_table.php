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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('url', 2048)->unique();
            $table->string('canonical_url', 2048)->nullable();
            $table->string('title', 500);
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('content_hash', 64)->nullable();
            $table->string('author', 255)->nullable();
            $table->string('site_name', 255)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->integer('reading_time')->nullable();
            $table->integer('word_count')->nullable();
            $table->string('language', 10)->nullable();
            $table->string('featured_image_url', 2048)->nullable();
            $table->string('favicon_url', 2048)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('last_fetched_at')->nullable();
            $table->timestamps();

            $table->index('url');
            $table->index('canonical_url');
            $table->index('content_hash');
            $table->index('published_at');
            $table->index('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
