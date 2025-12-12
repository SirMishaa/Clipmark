<?php

namespace App\Models;

use Database\Factories\ArticleVersionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @use HasFactory<ArticleVersionFactory>
 *
 * @mixin IdeHelperArticleVersion
 */
class ArticleVersion extends Model
{
    /** @use HasFactory<ArticleVersionFactory> */
    use HasFactory;

    protected $fillable = [
        'article_id',
        'content',
        'content_hash',
        'title',
        'author',
        'reading_time',
        'word_count',
        'metadata',
        'fetched_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'fetched_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Article, $this>
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
