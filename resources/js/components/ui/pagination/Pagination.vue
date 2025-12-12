<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    links: PaginationLink[];
    currentPage?: number;
    lastPage?: number;
    total?: number;
    from?: number;
    to?: number;
    class?: string;
}

const props = defineProps<Props>();

const isNumeric = (str: string): boolean => {
    return /^\d+$/.test(str);
};
</script>

<template>
    <nav
        role="navigation"
        aria-label="Pagination Navigation"
        :class="cn('flex items-center justify-center gap-1', props.class)"
    >
        <template v-for="(link, index) in links" :key="index">
            <!-- Previous Button -->
            <Button
                v-if="index === 0"
                variant="outline"
                size="sm"
                :disabled="!link.url"
                as-child
            >
                <Link
                    v-if="link.url"
                    :href="link.url"
                    preserve-scroll
                    class="flex items-center gap-1"
                >
                    <ChevronLeft class="size-4" />
                    <span class="sr-only">Previous</span>
                </Link>
                <span v-else class="flex items-center gap-1">
                    <ChevronLeft class="size-4" />
                    <span class="sr-only">Previous</span>
                </span>
            </Button>

            <!-- Page Numbers -->
            <Button
                v-else-if="index !== links.length - 1 && isNumeric(link.label)"
                :variant="link.active ? 'default' : 'outline'"
                size="sm"
                as-child
            >
                <Link
                    v-if="link.url"
                    :href="link.url"
                    preserve-scroll
                    :class="
                        cn(
                            'min-w-9',
                            link.active &&
                                'pointer-events-none bg-primary text-primary-foreground',
                        )
                    "
                >
                    {{ link.label }}
                </Link>
                <span
                    v-else
                    :class="
                        cn(
                            'min-w-9',
                            link.active &&
                                'pointer-events-none bg-primary text-primary-foreground',
                        )
                    "
                >
                    {{ link.label }}
                </span>
            </Button>

            <!-- Next Button -->
            <Button
                v-else-if="index === links.length - 1"
                variant="outline"
                size="sm"
                :disabled="!link.url"
                as-child
            >
                <Link
                    v-if="link.url"
                    :href="link.url"
                    preserve-scroll
                    class="flex items-center gap-1"
                >
                    <span class="sr-only">Next</span>
                    <ChevronRight class="size-4" />
                </Link>
                <span v-else class="flex items-center gap-1">
                    <span class="sr-only">Next</span>
                    <ChevronRight class="size-4" />
                </span>
            </Button>
        </template>
    </nav>

    <!-- Optional: Page info -->
    <div
        v-if="from && to && total"
        class="mt-4 text-center text-sm text-muted-foreground"
    >
        Showing {{ from }} to {{ to }} of {{ total }} results
    </div>
</template>
