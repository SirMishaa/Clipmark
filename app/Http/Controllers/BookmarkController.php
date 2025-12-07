<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Requests\BookmarkFilterRequest;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @phpstan-type BookmarkFilter 'starred'|'archived'|'unread' |null
 */
class BookmarkController extends Controller
{
    public function index(BookmarkFilterRequest $bookmarkFilterRequest): Response
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var BookmarkFilter $filter */
        $filter = $bookmarkFilterRequest->input('filter');
        $sort = $bookmarkFilterRequest->input('sort');
        $tag = $bookmarkFilterRequest->input('tag');

        $bookmarks = $user->bookmarks()
            ->orderBy(match ($sort) {
                'date' => 'created_at',
                'title' => 'title',
                'relevance' => 'updated_at',
                default => 'created_at',
            })
            ->when($filter === 'starred', fn ($query) => $query->where('is_starred', true))
            ->when($filter === 'archived', fn ($query) => $query->where('is_archived', true))
            ->when($filter === 'unread', fn ($query) => $query->where('is_read', false))
            ->with('bookmarkable')
            ->get();

        /**
         * @var object{total: int, starred: int, archived: int, unread: int} $stats
         */
        $stats = $user->bookmarks()
            ->select([
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN is_starred = 1 THEN 1 ELSE 0 END) as starred'),
                DB::raw('SUM(CASE WHEN is_archived = 1 THEN 1 ELSE 0 END) as archived'),
                DB::raw('SUM(CASE WHEN is_read = 0 THEN 1 ELSE 0 END) as unread'),
            ])
            ->first();

        return Inertia::render('Bookmarks/Index', [
            'bookmarks' => $bookmarks,
            'bookmarksStats' => [
                'total' => $stats->total,
                'starred' => $stats->starred,
                'archived' => $stats->archived,
                'unread' => $stats->unread,
            ],
        ]);
    }
}
