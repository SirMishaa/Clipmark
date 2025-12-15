<?php

namespace App\Models;

use Database\Factories\BookmarkFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @use HasFactory<BookmarkFactory>
 *
 * @mixin IdeHelperBookmark
 */
class Bookmark extends Model
{
    /** @use HasFactory<BookmarkFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'url',
        'user_id',
        'bookmarkable_type',
        'bookmarkable_id',
        'title',
        'excerpt',
        'is_starred',
        'is_read',
        'is_archived',
        'read_at',
        'saved_at',
    ];

    protected function casts(): array
    {
        return [
            'is_starred' => 'boolean',
            'is_read' => 'boolean',
            'is_archived' => 'boolean',
            'read_at' => 'datetime',
            'saved_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function bookmarkable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @param  Builder<Bookmark>  $query
     * @return Builder<Bookmark>
     */
    public function scopeStarred(Builder $query): Builder
    {
        return $query->where('is_starred', true);
    }

    /**
     * @param  Builder<Bookmark>  $query
     * @return Builder<Bookmark>
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }

    /**
     * @param  Builder<Bookmark>  $query
     * @return Builder<Bookmark>
     */
    public function scopeArchived(Builder $query): Builder
    {
        return $query->where('is_archived', true);
    }

    /**
     * @param  Builder<Bookmark>  $query
     * @return Builder<Bookmark>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_archived', false);
    }

    /**
     * @param  Builder<Bookmark>  $query
     * @return Builder<Bookmark>
     */
    public function scopeWithStats(Builder $query): Builder
    {
        return $query
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN is_starred THEN 1 ELSE 0 END) as starred')
            ->selectRaw('SUM(CASE WHEN is_archived THEN 1 ELSE 0 END) as archived')
            ->selectRaw('SUM(CASE WHEN NOT is_read THEN 1 ELSE 0 END) as unread');
    }

    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function markAsUnread(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    public function toggleStar(): void
    {
        $this->update(['is_starred' => ! $this->is_starred]);
    }

    public function archive(): void
    {
        $this->update(['is_archived' => true]);
    }

    public function unarchive(): void
    {
        $this->update(['is_archived' => false]);
    }
}
