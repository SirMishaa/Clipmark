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
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bookmarkable_type');
            $table->unsignedBigInteger('bookmarkable_id');

            $table->string('title', 500)->nullable();
            $table->text('excerpt')->nullable();
            $table->boolean('is_starred')->default(false);
            $table->boolean('is_read')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamp('saved_at');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('user_id');
            $table->index(['bookmarkable_type', 'bookmarkable_id']);
            $table->index('title');
            $table->index('is_starred');
            $table->index('is_read');
            $table->index('is_archived');
            $table->index('saved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
