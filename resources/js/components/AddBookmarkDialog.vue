<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Textarea } from '@/components/ui/textarea';
import { preview, store } from '@/routes/bookmarks';
import { Form, router } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { FileText, Link2, Loader2, Star, Type } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
    open?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    open: false,
    preview: null,
});

const emit = defineEmits<{
    'update:open': [value: boolean];
}>();

const isStarred = ref<boolean>(false);
const isLoadingPreview = ref<boolean>(false);
const previewData = ref<{
    title?: string;
    excerpt?: string;
    featured_image_url?: string;
} | null>(null);

// Debounced function to stop loading with minimum delay
const stopLoading = useDebounceFn(() => {
    isLoadingPreview.value = false;
}, 500);

const handleOpenChange = (value: boolean) => {
    emit('update:open', value);

    // Reset form state when closing
    if (!value) {
        isStarred.value = false;
        isLoadingPreview.value = false;
        previewData.value = null;
    }
};

const handlePasteLink = (event: ClipboardEvent) => {
    const clipboardData = event.clipboardData?.getData('text/plain');
    if (!clipboardData) return;

    // Validate URL
    try {
        new URL(clipboardData);
    } catch {
        return; // Invalid URL
    }

    // Fetch preview using Inertia
    isLoadingPreview.value = true;

    router.post(
        preview.url(),
        { url: clipboardData },
        {
            preserveScroll: true,
            only: ['preview'],
            onSuccess: (page) => {
                const data = page.props.preview as {
                    title?: string;
                    excerpt?: string;
                    featured_image_url?: string;
                };
                previewData.value = {
                    title: data?.title,
                    excerpt: data?.excerpt,
                    featured_image_url: data?.featured_image_url,
                };
            },
            onError: (errors) => {
                console.error('Failed to fetch preview:', errors);
            },
            onFinish: () => {
                stopLoading();
            },
        },
    );
};
</script>

<template>
    <Dialog :open="open" @update:open="handleOpenChange">
        <DialogContent class="max-w-xl gap-6">
            <DialogHeader>
                <DialogTitle class="text-2xl">Add Bookmark</DialogTitle>
                <DialogDescription>
                    Save an article to your collection. Just paste the URL and
                    we'll fetch the details.
                </DialogDescription>
            </DialogHeader>

            <!-- Image Preview -->
            <div
                v-if="previewData?.featured_image_url || isLoadingPreview"
                class="overflow-hidden rounded-lg border border-border bg-muted/30"
            >
                <div
                    class="relative aspect-video w-full"
                    :class="{
                        'animate-pulse bg-muted/50': isLoadingPreview,
                    }"
                >
                    <img
                        v-if="
                            previewData?.featured_image_url && !isLoadingPreview
                        "
                        :src="previewData.featured_image_url"
                        :alt="previewData?.title || 'Preview image'"
                        class="size-full object-cover"
                    />
                    <div
                        v-if="isLoadingPreview"
                        class="absolute inset-0 flex items-center justify-center"
                    >
                        <Loader2
                            class="size-8 animate-spin text-muted-foreground"
                        />
                    </div>
                </div>
            </div>

            <Form
                :action="store()"
                :reset-on-success="true"
                v-slot="{ errors, processing }"
                @success="handleOpenChange(false)"
                :show-progress="true"
                class="space-y-6"
            >
                <!-- URL Field (Required) -->
                <div class="grid gap-3">
                    <Label for="url" class="text-base font-medium">
                        Article URL
                        <span class="text-destructive">*</span>
                    </Label>
                    <div class="relative">
                        <Link2
                            class="absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
                        />
                        <Input
                            id="url"
                            name="url"
                            type="url"
                            @paste="handlePasteLink"
                            required
                            autofocus
                            placeholder="https://example.com/article"
                            class="pl-10"
                            :aria-invalid="!!errors.url"
                        />
                    </div>
                    <InputError :message="errors.url" />
                </div>

                <!-- Title Field (Optional) -->
                <div class="grid gap-3">
                    <Label for="title" class="flex items-center gap-2">
                        <span class="text-base font-medium">
                            Custom Title
                        </span>
                        <span
                            v-if="isLoadingPreview"
                            class="text-xs text-muted-foreground"
                        >
                            (Fetching...)
                        </span>
                        <span v-else class="text-xs text-muted-foreground">
                            (Optional - we'll fetch it for you)
                        </span>
                    </Label>
                    <div class="relative">
                        <Type
                            class="absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
                        />
                        <Loader2
                            v-if="isLoadingPreview"
                            class="absolute top-1/2 right-3 size-4 -translate-y-1/2 animate-spin text-muted-foreground"
                        />
                        <Input
                            id="title"
                            name="title"
                            type="text"
                            :placeholder="
                                previewData?.title ||
                                'Override the article title'
                            "
                            :value="previewData?.title"
                            class="pl-10 transition-all duration-300"
                            :class="{
                                'animate-pulse bg-muted/50 pr-10':
                                    isLoadingPreview,
                                'bg-primary/5 dark:bg-primary/10':
                                    previewData?.title && !isLoadingPreview,
                            }"
                            :aria-invalid="!!errors.title"
                            :disabled="isLoadingPreview"
                        />
                    </div>
                    <InputError :message="errors.title" />
                </div>

                <!-- Excerpt Field (Optional) -->
                <div class="grid gap-3">
                    <Label for="excerpt" class="flex items-center gap-2">
                        <span class="text-base font-medium">
                            Custom Excerpt
                        </span>
                        <span class="text-xs text-muted-foreground">
                            (Optional)
                        </span>
                    </Label>
                    <div class="relative">
                        <FileText
                            class="absolute top-3 left-3 size-4 text-muted-foreground"
                        />
                        <Loader2
                            v-if="isLoadingPreview"
                            class="absolute top-3 right-3 size-4 animate-spin text-muted-foreground"
                        />
                        <Textarea
                            id="excerpt"
                            name="excerpt"
                            :placeholder="
                                previewData?.excerpt ||
                                'Add a custom description or note...'
                            "
                            :value="previewData?.excerpt"
                            class="min-h-24 resize-none pl-10 transition-all duration-300"
                            :class="{
                                'animate-pulse bg-muted/50 pr-10':
                                    isLoadingPreview,
                                'bg-primary/5 dark:bg-primary/10':
                                    previewData?.excerpt && !isLoadingPreview,
                            }"
                            :aria-invalid="!!errors.excerpt"
                            :disabled="isLoadingPreview"
                        />
                    </div>
                    <InputError :message="errors.excerpt" />
                </div>

                <!-- Star Checkbox -->
                <div
                    class="flex items-center gap-3 rounded-lg border border-border bg-muted/30 p-4"
                >
                    <Checkbox
                        id="is_starred"
                        name="is_starred"
                        v-model:checked="isStarred"
                        :aria-invalid="!!errors.is_starred"
                    />
                    <Label
                        for="is_starred"
                        class="flex cursor-pointer items-center gap-2 text-sm leading-none font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                    >
                        <Star
                            class="size-4"
                            :class="
                                isStarred
                                    ? 'fill-yellow-400 text-yellow-400'
                                    : 'text-muted-foreground'
                            "
                        />
                        Star this bookmark
                    </Label>
                    <InputError :message="errors.is_starred" />
                </div>

                <DialogFooter class="gap-3 sm:gap-2">
                    <Button
                        type="button"
                        variant="outline"
                        @click="handleOpenChange(false)"
                        :disabled="processing"
                    >
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="processing" class="gap-2">
                        <Spinner v-if="processing" class="size-4" />
                        <span v-if="processing">Saving...</span>
                        <span v-else>Save Bookmark</span>
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
