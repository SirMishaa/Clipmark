<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { useRelativeDate } from '@/composables/useRelativeDate';
import AppLayout from '@/layouts/AppLayout.vue';
import { bookmarkSchema } from '@/schemas/bookmarks';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { type } from 'arktype';
import {
    Bookmark,
    Clock,
    ExternalLink,
    Grid3x3,
    List,
    Plus,
    Search,
    Star,
} from 'lucide-vue-next';
import { onMounted, ref } from 'vue';

interface Props {
    bookmarks: Array<models.Bookmark & { bookmarkable?: models.Article }>;
}

const props = withDefaults(defineProps<Props>(), {
    bookmarks: () => [],
});

onMounted(() => {
    props.bookmarks.forEach((bookmark, index) => {
        const result = bookmarkSchema(bookmark);
        if (result instanceof type.errors) {
            console.warn(
                `⚠️ Bookmark validation failed at index ${index}:`,
                result.summary,
            );
        }
    });
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'All Bookmarks',
        href: '#',
    },
];

const viewMode = ref<'grid' | 'list'>('grid');

const formatReadingTime = (seconds: number | null): string => {
    if (!seconds) return 'Unknown';
    const minutes = Math.ceil(seconds / 60);
    return `${minutes} min`;
};
</script>

<template>
    <Head title="All Bookmarks" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header Section -->
            <div
                class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
            >
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">
                        All Bookmarks
                    </h1>
                    <p class="mt-1 text-muted-foreground">
                        {{ bookmarks.length }} bookmarks saved
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <Button variant="outline" size="sm">
                        <Plus class="mr-2 size-4" />
                        Add Bookmark
                    </Button>
                    <div
                        class="flex gap-1 rounded-lg border border-border bg-muted/30 p-1"
                    >
                        <Button
                            variant="ghost"
                            size="sm"
                            :class="
                                viewMode === 'grid'
                                    ? 'bg-background shadow-sm'
                                    : ''
                            "
                            @click="viewMode = 'grid'"
                        >
                            <Grid3x3 class="size-4" />
                        </Button>
                        <Button
                            variant="ghost"
                            size="sm"
                            :class="
                                viewMode === 'list'
                                    ? 'bg-background shadow-sm'
                                    : ''
                            "
                            @click="viewMode = 'list'"
                        >
                            <List class="size-4" />
                        </Button>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="relative max-w-md">
                <Search
                    class="absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
                />
                <Input
                    type="search"
                    placeholder="Search bookmarks..."
                    class="pl-10"
                />
            </div>

            <!-- Grid View -->
            <div
                v-if="viewMode === 'grid'"
                class="grid gap-6 md:grid-cols-2 lg:grid-cols-3"
            >
                <Card
                    v-for="bookmark in bookmarks"
                    :key="bookmark.id"
                    class="group overflow-hidden transition-all hover:shadow-lg"
                >
                    <div class="relative aspect-video overflow-hidden bg-muted">
                        <img
                            v-if="bookmark.bookmarkable.featured_image_url"
                            :src="bookmark.bookmarkable.featured_image_url"
                            :alt="bookmark.title || bookmark.bookmarkable.title"
                            class="size-full object-cover transition-transform duration-300 group-hover:scale-105"
                        />
                        <div
                            v-else
                            class="flex size-full items-center justify-center bg-gradient-to-br from-muted to-muted-foreground/10"
                        >
                            <Bookmark
                                class="size-12 text-muted-foreground/30"
                            />
                        </div>
                        <div class="absolute top-2 right-2 flex gap-2">
                            <Button
                                size="sm"
                                variant="secondary"
                                class="size-8 rounded-full p-0 shadow-md"
                            >
                                <Star
                                    class="size-4"
                                    :class="
                                        bookmark.is_starred
                                            ? 'fill-yellow-400 text-yellow-400'
                                            : ''
                                    "
                                />
                            </Button>
                        </div>
                    </div>

                    <CardHeader class="pb-3">
                        <div
                            class="mb-2 flex items-start justify-between gap-2"
                        >
                            <Badge
                                v-if="bookmark.bookmarkable.site_name"
                                variant="secondary"
                            >
                                {{ bookmark.bookmarkable.site_name }}
                            </Badge>
                        </div>
                        <CardTitle class="line-clamp-2 text-lg leading-tight">
                            {{ bookmark.title || bookmark.bookmarkable.title }}
                        </CardTitle>
                        <CardDescription class="line-clamp-2 text-sm">
                            {{
                                bookmark.excerpt ||
                                bookmark.bookmarkable.excerpt
                            }}
                        </CardDescription>
                    </CardHeader>

                    <CardContent class="pt-0">
                        <div
                            class="mt-4 flex items-center justify-between text-sm text-muted-foreground"
                        >
                            <div class="flex items-center gap-1">
                                <Clock class="size-3.5" />
                                <span>{{
                                    formatReadingTime(
                                        bookmark.bookmarkable.reading_time,
                                    )
                                }}</span>
                            </div>
                            <span>{{
                                useRelativeDate(bookmark.saved_at)
                            }}</span>
                        </div>

                        <Button
                            variant="ghost"
                            size="sm"
                            class="mt-3 w-full"
                            as-child
                        >
                            <a
                                :href="bookmark.bookmarkable.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                v-if="!bookmark.is_archived"
                            >
                                <ExternalLink class="mr-2 size-4" />
                                Open Article
                            </a>
                            <span
                                v-else
                                class="mr-2 flex size-4 cursor-not-allowed items-center justify-center"
                            >
                                Archived
                            </span>
                        </Button>
                    </CardContent>
                </Card>
            </div>

            <!-- List View -->
            <div v-else class="flex flex-col gap-4">
                <Card
                    v-for="bookmark in bookmarks"
                    :key="bookmark.id"
                    class="group transition-all hover:shadow-md"
                    :class="bookmark.is_read ? 'opacity-60' : ''"
                >
                    <CardContent class="p-4">
                        <div class="flex gap-4">
                            <div
                                class="relative size-32 flex-shrink-0 overflow-hidden rounded-lg bg-muted"
                            >
                                <img
                                    v-if="
                                        bookmark.bookmarkable.featured_image_url
                                    "
                                    :src="
                                        bookmark.bookmarkable.featured_image_url
                                    "
                                    :alt="
                                        bookmark.title ||
                                        bookmark.bookmarkable.title
                                    "
                                    class="size-full object-cover transition-transform duration-300 group-hover:scale-105"
                                />
                                <div
                                    v-else
                                    class="flex size-full items-center justify-center bg-gradient-to-br from-muted to-muted-foreground/10"
                                >
                                    <Bookmark
                                        class="size-8 text-muted-foreground/30"
                                    />
                                </div>
                            </div>

                            <div class="flex flex-1 flex-col justify-between">
                                <div>
                                    <div class="mb-2 flex items-center gap-2">
                                        <Badge
                                            v-if="
                                                bookmark.bookmarkable.site_name
                                            "
                                            variant="secondary"
                                            class="text-xs"
                                        >
                                            {{
                                                bookmark.bookmarkable.site_name
                                            }}
                                        </Badge>
                                        <span
                                            class="text-xs text-muted-foreground"
                                            >{{
                                                useRelativeDate(
                                                    bookmark.saved_at,
                                                )
                                            }}</span
                                        >
                                    </div>
                                    <h3
                                        class="mb-2 line-clamp-1 text-lg font-semibold"
                                    >
                                        {{
                                            bookmark.title ||
                                            bookmark.bookmarkable.title
                                        }}
                                    </h3>
                                    <p
                                        class="line-clamp-2 text-sm text-muted-foreground"
                                    >
                                        {{
                                            bookmark.excerpt ||
                                            bookmark.bookmarkable.excerpt
                                        }}
                                    </p>
                                </div>

                                <div
                                    class="mt-3 flex items-center justify-between"
                                >
                                    <div
                                        class="flex items-center gap-1 text-xs text-muted-foreground"
                                    >
                                        <Clock class="size-3.5" />
                                        <span>{{
                                            formatReadingTime(
                                                bookmark.bookmarkable
                                                    .reading_time,
                                            )
                                        }}</span>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <Button
                                            size="sm"
                                            variant="ghost"
                                            class="size-8 p-0"
                                        >
                                            <Star
                                                class="size-4"
                                                :class="
                                                    bookmark.is_starred
                                                        ? 'fill-yellow-400 text-yellow-400'
                                                        : ''
                                                "
                                            />
                                        </Button>
                                        <Button
                                            size="sm"
                                            variant="outline"
                                            as-child
                                        >
                                            <a
                                                :href="
                                                    bookmark.bookmarkable.url
                                                "
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >
                                                <ExternalLink
                                                    class="mr-2 size-4"
                                                />
                                                Open
                                            </a>
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Empty State -->
            <div
                v-if="bookmarks.length === 0"
                class="flex flex-col items-center justify-center py-12"
            >
                <Bookmark class="mb-4 size-12 text-muted-foreground/50" />
                <h3 class="mb-2 text-lg font-semibold">No bookmarks yet</h3>
                <p class="mb-4 text-sm text-muted-foreground">
                    Start saving articles to see them here
                </p>
                <Button>
                    <Plus class="mr-2 size-4" />
                    Add Your First Bookmark
                </Button>
            </div>
        </div>
    </AppLayout>
</template>
