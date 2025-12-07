<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { index } from '@/routes/bookmarks';
import { Link, usePage } from '@inertiajs/vue3';
import { Archive, BookmarkPlus, Home, Rss, Star } from 'lucide-vue-next';
import { computed } from 'vue';

const page = usePage();

const bookmarksStats = computed(() => {
    return {
        all: page.props.bookmarksStats?.total || 0,
        starred: page.props.bookmarksStats?.starred || 0,
        unread: page.props.bookmarksStats?.unread || 0,
        archived: page.props.bookmarksStats?.archived || 0,
    };
});

console.log(page.props.bookmarks);
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>My Bookmarks</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem>
                <SidebarMenuButton as-child>
                    <Link :href="index()">
                        <Home />
                        <span>All Items</span>
                        <Badge variant="secondary" class="ml-auto text-xs">
                            {{ bookmarksStats.all }}
                        </Badge>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>

            <SidebarMenuItem>
                <SidebarMenuButton as-child>
                    <Link
                        :href="
                            index({
                                query: {
                                    filter: 'starred',
                                },
                            })
                        "
                    >
                        <Star />
                        <span>Starred</span>
                        <Badge variant="secondary" class="ml-auto text-xs">
                            {{ bookmarksStats.starred }}
                        </Badge>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>

            <SidebarMenuItem>
                <SidebarMenuButton as-child>
                    <Link
                        :href="
                            index({
                                query: {
                                    filter: 'unread',
                                },
                            })
                        "
                    >
                        <BookmarkPlus />
                        <span>Unread</span>
                        <Badge variant="secondary" class="ml-auto text-xs">
                            {{ bookmarksStats.unread }}
                        </Badge>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>

            <SidebarMenuItem>
                <SidebarMenuButton as-child>
                    <Link
                        :href="
                            index({
                                query: {
                                    filter: 'archived',
                                },
                            })
                        "
                    >
                        <Archive />
                        <span>Archived</span>
                        <Badge variant="outline" class="ml-auto text-xs">
                            {{ bookmarksStats.archived }}
                        </Badge>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>

            <SidebarGroup class="px-2 py-0">
                <SidebarGroupLabel>Sources</SidebarGroupLabel>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton as-child>
                            <Link href="#">
                                <Rss />
                                <span>RSS Feeds</span>
                                <span
                                    class="ml-auto text-xs text-muted-foreground"
                                >
                                    Soon
                                </span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarGroup>
        </SidebarMenu>
    </SidebarGroup>
</template>
