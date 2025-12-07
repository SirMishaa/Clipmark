<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Bookmark;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin Model
 */
trait Bookmarkable
{
    /**
     * @return MorphMany<Bookmark, $this>
     */
    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}
