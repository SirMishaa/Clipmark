export {};

declare global {
    export namespace models {
        export interface Bookmark {
            // columns
            id: number;
            user_id: number;
            bookmarkable_type: string;
            bookmarkable_id: number;
            title: string | null;
            excerpt: string | null;
            is_starred: boolean;
            is_read: boolean;
            is_archived: boolean;
            read_at: string | null;
            saved_at: string;
            created_at: string | null;
            updated_at: string | null;
            deleted_at: string | null;
            // relations
            user: User;
            bookmarkable: Article | null;
            // exists
            user_exists?: boolean;
        }

        export interface ArticleVersion {
            // columns
            id: number;
            article_id: number;
            content: string;
            content_hash: string;
            title: string;
            author: string | null;
            reading_time: number | null;
            word_count: number | null;
            metadata: Record<string, unknown> | null;
            fetched_at: string;
            created_at: string | null;
            updated_at: string | null;
            // relations
            article: Article;
            // exists
            article_exists?: boolean;
        }

        export interface Article {
            // columns
            id: number;
            url: string;
            canonical_url: string | null;
            title: string;
            excerpt: string | null;
            content: string | null;
            content_hash: string | null;
            author: string | null;
            site_name: string | null;
            published_at: string | null;
            reading_time: number | null;
            word_count: number | null;
            language: string | null;
            featured_image_url: string | null;
            favicon_url: string | null;
            metadata: Array<unknown> | null;
            last_fetched_at: string | null;
            created_at: string | null;
            updated_at: string | null;
            // relations
            versions: ArticleVersion[];
            bookmarks: Bookmark[];
            // exists
            versions_exists?: boolean;
            bookmarks_exists?: boolean;
        }

        export interface User {
            // columns
            id: number;
            name: string;
            email: string;
            email_verified_at: string | null;
            password?: string;
            remember_token?: string | null;
            created_at: string | null;
            updated_at: string | null;
            two_factor_secret?: string | null;
            two_factor_recovery_codes?: string | null;
            two_factor_confirmed_at: string | null;
            // relations
            bookmarks: Bookmark[];
            notifications: DatabaseNotification[];
            // exists
            bookmarks_exists?: boolean;
            notifications_exists?: boolean;
        }
    }
}
