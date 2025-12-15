<?php

namespace App\Http\Controllers;

use App\BookmarkFilter;
use App\Http\Requests\BookmarkFilterRequest;
use App\Http\Requests\StoreBookmarkRequest;
use App\Models\User;
use App\Services\WebScraper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class BookmarkController extends Controller
{
    public function index(BookmarkFilterRequest $bookmarkFilterRequest): Response
    {
        /** @var User $user */
        $user = auth()->user();

        $filter = $bookmarkFilterRequest->enum('filter', BookmarkFilter::class);
        $sort = $bookmarkFilterRequest->input('sort');
        /* $tag = $bookmarkFilterRequest->input('tag'); */

        $bookmarks = $user->bookmarks()
            ->orderBy(...match ($sort) {
                'date' => ['created_at', 'desc'],
                'title' => ['title', 'asc'],
                'relevance' => ['updated_at', 'desc'],
                default => ['created_at', 'desc'],
            })
            ->when($filter, fn ($query) => /** @phpstan-ignore match.unhandled */ match ($filter) {
                BookmarkFilter::Starred => $query->starred(),
                BookmarkFilter::Archived => $query->archived(),
                BookmarkFilter::Unread => $query->unread(),
            })
            ->with('bookmarkable')
            ->paginate(15);

        /**
         * @var object{total: int, starred: int, archived: int, unread: int} $stats
         *
         * @uses \App\Models\Bookmark::scopeWithStats()
         */
        $stats = $user->bookmarks()->withStats()->first();

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

    public function preview(Request $request, WebScraper $scraper): Response
    {
        $validated = $request->validate([
            'url' => ['required', 'url', 'max:2048'],
        ]);

        $metadata = $scraper->extractMetadata($validated['url']);

        $previewData = [
            'url' => $validated['url'],
            'title' => $metadata->title,
            'excerpt' => $metadata->description,
            'featured_image_url' => $metadata->image,
            /** Not implemented in the scraper yet */
            'author' => $metadata->author,
            'site_name' => $metadata->siteName,
        ];

        return Inertia::render('Bookmarks/Index', [
            'preview' => $previewData,
        ]);
    }

    public function store(StoreBookmarkRequest $request): RedirectResponse
    {

        $user = $this->user($request);

        $validated = $request->validated();

        $bookmark = $user->bookmarks()->create([
            'url' => $validated['url'],
            'title' => $validated['title'] ?? null,
            'excerpt' => $validated['excerpt'] ?? null,
            'is_starred' => $validated['is_starred'] ?? false,
            'is_read' => $validated['is_read'] ?? false,
            'saved_at' => now(),
        ]);

        Log::info('New bookmark created', [
            'user_id' => $user->id,
            'title' => $bookmark->title,
            'url' => $bookmark->url,
        ]);

        return redirect()->route('bookmarks.index')->with('success', 'Bookmark added successfully.');
    }
}
