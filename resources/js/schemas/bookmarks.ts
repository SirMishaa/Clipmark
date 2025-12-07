import { type } from 'arktype';

/**
 * Article validation schema (validates data properties only, not relations)
 */
export const articleSchema = type({
    id: 'number',
    url: 'string',
    'canonical_url?': 'string | null',
    title: 'string',
    'excerpt?': 'string | null',
    'content?': 'string | null',
    'content_hash?': 'string | null',
    'author?': 'string | null',
    'site_name?': 'string | null',
    'published_at?': 'string | null',
    'reading_time?': 'number | null',
    'word_count?': 'number | null',
    'language?': 'string | null',
    'featured_image_url?': 'string | null',
    'favicon_url?': 'string | null',
    'metadata?': 'Record<string, unknown> | null',
    'last_fetched_at?': 'string | null',
    'created_at?': 'string | null',
    'updated_at?': 'string | null',
});

/**
 * Bookmark validation schema (validates data properties only, not relations)
 */
export const bookmarkSchema = type({
    id: 'number',
    user_id: 'number',
    bookmarkable_type: 'string',
    bookmarkable_id: 'number',
    'title?': 'string | null',
    'excerpt?': 'string | null',
    is_starred: 'boolean',
    is_read: 'boolean',
    is_archived: 'boolean',
    'read_at?': 'string | null',
    saved_at: 'string',
    'created_at?': 'string | null',
    'updated_at?': 'string | null',
    'deleted_at?': 'string | null',
    'bookmarkable?': articleSchema.or('undefined'),
});
