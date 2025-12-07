<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { Link } from '@inertiajs/vue3';
import { BookmarkCheck, Folder } from 'lucide-vue-next';

const collections = [
    { name: 'Work', icon: Folder, count: 5 },
    { name: 'Learning', icon: BookmarkCheck, count: 8 },
];
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Collections</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem
                v-for="collection in collections"
                :key="collection.name"
            >
                <SidebarMenuButton as-child>
                    <Link href="#">
                        <component :is="collection.icon" />
                        <span>{{ collection.name }}</span>
                        <Badge variant="outline" class="ml-auto text-xs">
                            {{ collection.count }}
                        </Badge>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
