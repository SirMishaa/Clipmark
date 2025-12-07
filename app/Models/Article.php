<?php

namespace App\Models;

use App\Concerns\Bookmarkable;
use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @use HasFactory<ArticleFactory>
 */
class Article extends Model
{
    use Bookmarkable;

    /** @use HasFactory<ArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'url',
        'canonical_url',
        'title',
        'excerpt',
        'content',
        'content_hash',
        'author',
        'site_name',
        'published_at',
        'reading_time',
        'word_count',
        'language',
        'featured_image_url',
        'favicon_url',
        'metadata',
        'last_fetched_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'published_at' => 'datetime',
            'last_fetched_at' => 'datetime',
        ];
    }

    /**
     * @return HasMany<ArticleVersion, $this>
     */
    public function versions(): HasMany
    {
        return $this->hasMany(ArticleVersion::class);
    }

    public function createVersion(): ArticleVersion
    {
        return $this->versions()->create([
            'content' => $this->content,
            'content_hash' => $this->content_hash,
            'title' => $this->title,
            'author' => $this->author,
            'reading_time' => $this->reading_time,
            'word_count' => $this->word_count,
            'metadata' => $this->metadata,
            'fetched_at' => $this->last_fetched_at ?? now(),
        ]);
    }

    public function hasContentChanged(string $newContent): bool
    {
        $newHash = hash('sha256', $newContent);

        return $this->content_hash !== $newHash;
    }

    /**
     * @param  array<string, mixed>  $additionalData
     */
    public function updateContent(string $newContent, array $additionalData = []): void
    {
        $newHash = hash('sha256', $newContent);

        if ($this->content && $this->content_hash !== $newHash) {
            $this->createVersion();
        }

        $this->update([
            'content' => $newContent,
            'content_hash' => $newHash,
            'last_fetched_at' => now(),
            ...$additionalData,
        ]);
    }
}
