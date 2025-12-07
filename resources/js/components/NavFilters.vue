<script setup lang="ts">
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { Link } from '@inertiajs/vue3';
import { Calendar, Clock, Rss, Tag } from 'lucide-vue-next';

const topTags = [
    { name: 'Vue', count: 4 },
    { name: 'Laravel', count: 3 },
    { name: 'Design', count: 2 },
];
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Quick Filters</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem>
                <SidebarMenuButton as-child>
                    <Link href="#">
                        <Calendar />
                        <span>Recent (7 days)</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>

            <SidebarMenuItem>
                <SidebarMenuButton as-child>
                    <Link href="#">
                        <Clock />
                        <span>Quick reads</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>

    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Top Tags</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="tag in topTags" :key="tag.name">
                <SidebarMenuButton as-child>
                    <Link href="#">
                        <Tag />
                        <span>{{ tag.name }}</span>
                        <span class="ml-auto text-xs text-muted-foreground">
                            {{ tag.count }}
                        </span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>

    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Sources</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem>
                <SidebarMenuButton as-child>
                    <Link href="#">
                        <Rss />
                        <span>RSS Feeds</span>
                        <span class="ml-auto text-xs text-muted-foreground">
                            Soon
                        </span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
