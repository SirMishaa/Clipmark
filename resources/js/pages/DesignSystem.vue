<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { Skeleton } from '@/components/ui/skeleton';
import { Spinner } from '@/components/ui/spinner';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import {
    AlertCircle,
    Archive,
    Bookmark,
    Calendar,
    Check,
    ChevronDown,
    Clock,
    ExternalLink,
    Grid3x3,
    Heart,
    Home,
    Info,
    List,
    Loader2,
    Mail,
    Plus,
    Rss,
    Search,
    Settings,
    Star,
    Tag,
    Terminal,
    Trash2,
    User,
    X,
    Zap,
} from 'lucide-vue-next';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Design System',
        href: '#',
    },
];

const viewMode = ref<'grid' | 'list'>('grid');
const isCollapsibleOpen = ref(false);

// Navigation sections
const sections = [
    { id: 'typography', title: 'Typography', icon: 'Type' },
    { id: 'buttons', title: 'Buttons', icon: 'Hand' },
    { id: 'badges', title: 'Badges', icon: 'Tag' },
    { id: 'inputs', title: 'Form Inputs', icon: 'FileInput' },
    { id: 'alerts', title: 'Alerts', icon: 'AlertCircle' },
    { id: 'avatars', title: 'Avatars', icon: 'User' },
    { id: 'loading', title: 'Loading States', icon: 'Loader2' },
    { id: 'collapsible', title: 'Collapsible', icon: 'ChevronDown' },
    { id: 'icons', title: 'Icons', icon: 'Zap' },
    { id: 'articles', title: 'Article Components', icon: 'Bookmark' },
    { id: 'colors', title: 'Color Palette', icon: 'Palette' },
];

const scrollToSection = (sectionId: string) => {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
};

// Mock data pour la section articles
const articles = [
    {
        id: 1,
        title: 'Understanding Vue 3 Composition API: A Complete Guide',
        excerpt:
            "Learn how to leverage the power of Vue 3's Composition API to build more maintainable and scalable applications...",
        url: 'https://example.com/vue-composition-api',
        image: 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=800&auto=format&fit=crop',
        category: 'Development',
        tags: ['Vue', 'JavaScript', 'Frontend'],
        readTime: 8,
        savedAt: '2 hours ago',
        isStarred: true,
        isRead: false,
    },
    {
        id: 2,
        title: 'The Future of Web Development in 2025',
        excerpt:
            'Exploring emerging trends, frameworks, and technologies that will shape how we build web applications...',
        url: 'https://example.com/future-web-dev',
        image: 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&auto=format&fit=crop',
        category: 'Technology',
        tags: ['Web', 'Trends', 'AI'],
        readTime: 12,
        savedAt: '1 day ago',
        isStarred: false,
        isRead: true,
    },
    {
        id: 3,
        title: 'Mastering Tailwind CSS: Tips and Tricks',
        excerpt:
            'Discover advanced techniques and best practices for building beautiful UIs with Tailwind CSS...',
        url: 'https://example.com/tailwind-tips',
        image: 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&auto=format&fit=crop',
        category: 'Design',
        tags: ['CSS', 'Tailwind', 'UI'],
        readTime: 6,
        savedAt: '3 days ago',
        isStarred: true,
        isRead: false,
    },
];
</script>

<template>
    <Head title="Design System - Clipmark" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 overflow-y-auto p-6">
            <!-- Header -->
            <div class="space-y-2">
                <h1 class="text-4xl font-bold tracking-tight">
                    Clipmark Design System
                </h1>
                <p class="text-lg text-muted-foreground">
                    Composants UI et patterns de design pour l'application
                    Clipmark
                </p>
            </div>

            <!-- Table of Contents / Quick Navigation -->
            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <List class="size-5" />
                        Navigation Rapide
                    </CardTitle>
                    <CardDescription>
                        Cliquez pour accéder directement à une section
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div
                        class="grid gap-3 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                    >
                        <Button
                            v-for="section in sections"
                            :key="section.id"
                            variant="outline"
                            class="justify-start"
                            @click="scrollToSection(section.id)"
                        >
                            <component
                                :is="
                                    section.icon === 'Type'
                                        ? Terminal
                                        : section.icon === 'Hand'
                                          ? Settings
                                          : section.icon === 'Tag'
                                            ? Tag
                                            : section.icon === 'FileInput'
                                              ? Mail
                                              : section.icon === 'AlertCircle'
                                                ? AlertCircle
                                                : section.icon === 'User'
                                                  ? User
                                                  : section.icon === 'Loader2'
                                                    ? Loader2
                                                    : section.icon ===
                                                        'ChevronDown'
                                                      ? ChevronDown
                                                      : section.icon === 'Zap'
                                                        ? Zap
                                                        : section.icon ===
                                                            'Bookmark'
                                                          ? Bookmark
                                                          : Archive
                                "
                                class="mr-2 size-4"
                            />
                            {{ section.title }}
                        </Button>
                    </div>
                </CardContent>
            </Card>

            <Separator />

            <!-- Typography Section -->
            <section id="typography" class="scroll-mt-6 space-y-6">
                <div>
                    <h2 class="mb-2 text-2xl font-bold">Typography</h2>
                    <p class="text-muted-foreground">
                        Styles de texte et headings
                    </p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Headings</CardTitle>
                        <CardDescription
                            >Différents niveaux de titres</CardDescription
                        >
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div>
                            <h1 class="text-4xl font-bold">
                                Heading 1 - 4xl Bold
                            </h1>
                            <code class="text-sm text-muted-foreground"
                                >text-4xl font-bold</code
                            >
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold">
                                Heading 2 - 3xl Bold
                            </h2>
                            <code class="text-sm text-muted-foreground"
                                >text-3xl font-bold</code
                            >
                        </div>
                        <div>
                            <h3 class="text-2xl font-semibold">
                                Heading 3 - 2xl Semibold
                            </h3>
                            <code class="text-sm text-muted-foreground"
                                >text-2xl font-semibold</code
                            >
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold">
                                Heading 4 - xl Semibold
                            </h4>
                            <code class="text-sm text-muted-foreground"
                                >text-xl font-semibold</code
                            >
                        </div>
                        <div>
                            <p class="text-base">Body text - Base</p>
                            <code class="text-sm text-muted-foreground"
                                >text-base</code
                            >
                        </div>
                        <div>
                            <p class="text-sm text-muted-foreground">
                                Muted text - Small Muted
                            </p>
                            <code class="text-sm text-muted-foreground"
                                >text-sm text-muted-foreground</code
                            >
                        </div>
                    </CardContent>
                </Card>
            </section>

            <Separator />

            <!-- Buttons Section -->
            <section id="buttons" class="scroll-mt-6 space-y-6">
                <div>
                    <h2 class="mb-2 text-2xl font-bold">Buttons</h2>
                    <p class="text-muted-foreground">
                        Différents styles et tailles de boutons
                    </p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Button Variants</CardTitle>
                        <CardDescription
                            >Styles de boutons disponibles</CardDescription
                        >
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <div class="space-y-2">
                            <p class="text-sm font-medium">Primary</p>
                            <div class="flex flex-wrap gap-3">
                                <Button variant="default">Default</Button>
                                <Button variant="default" size="sm"
                                    >Small</Button
                                >
                                <Button variant="default" size="lg"
                                    >Large</Button
                                >
                                <Button variant="default" disabled
                                    >Disabled</Button
                                >
                            </div>
                        </div>

                        <div class="space-y-2">
                            <p class="text-sm font-medium">Secondary</p>
                            <div class="flex flex-wrap gap-3">
                                <Button variant="secondary">Secondary</Button>
                                <Button variant="secondary" size="sm"
                                    >Small</Button
                                >
                                <Button variant="secondary" size="lg"
                                    >Large</Button
                                >
                            </div>
                        </div>

                        <div class="space-y-2">
                            <p class="text-sm font-medium">Outline</p>
                            <div class="flex flex-wrap gap-3">
                                <Button variant="outline">Outline</Button>
                                <Button variant="outline" size="sm"
                                    >Small</Button
                                >
                                <Button variant="outline" size="lg"
                                    >Large</Button
                                >
                            </div>
                        </div>

                        <div class="space-y-2">
                            <p class="text-sm font-medium">Ghost</p>
                            <div class="flex flex-wrap gap-3">
                                <Button variant="ghost">Ghost</Button>
                                <Button variant="ghost" size="sm">Small</Button>
                                <Button variant="ghost" size="lg">Large</Button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <p class="text-sm font-medium">Destructive</p>
                            <div class="flex flex-wrap gap-3">
                                <Button variant="destructive"
                                    >Destructive</Button
                                >
                                <Button variant="destructive" size="sm"
                                    >Small</Button
                                >
                                <Button variant="destructive" size="lg"
                                    >Large</Button
                                >
                            </div>
                        </div>

                        <div class="space-y-2">
                            <p class="text-sm font-medium">With Icons</p>
                            <div class="flex flex-wrap gap-3">
                                <Button>
                                    <Plus class="mr-2 size-4" />
                                    Add Article
                                </Button>
                                <Button variant="outline">
                                    <Search class="mr-2 size-4" />
                                    Search
                                </Button>
                                <Button variant="ghost">
                                    <Settings class="mr-2 size-4" />
                                    Settings
                                </Button>
                                <Button variant="destructive">
                                    <Trash2 class="mr-2 size-4" />
                                    Delete
                                </Button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <p class="text-sm font-medium">Icon Only</p>
                            <div class="flex flex-wrap gap-3">
                                <Button size="sm" class="size-8 p-0">
                                    <Star class="size-4" />
                                </Button>
                                <Button
                                    size="sm"
                                    variant="outline"
                                    class="size-8 p-0"
                                >
                                    <Bookmark class="size-4" />
                                </Button>
                                <Button
                                    size="sm"
                                    variant="ghost"
                                    class="size-8 p-0"
                                >
                                    <Heart class="size-4" />
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </section>

            <Separator />

            <!-- Badges Section -->
            <section class="space-y-6">
                <div>
                    <h2 class="mb-2 text-2xl font-bold">Badges</h2>
                    <p class="text-muted-foreground">Étiquettes et tags</p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Badge Variants</CardTitle>
                        <CardDescription
                            >Différents styles de badges</CardDescription
                        >
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <p class="text-sm font-medium">Default</p>
                                <div class="flex flex-wrap gap-2">
                                    <Badge>Default</Badge>
                                    <Badge>Development</Badge>
                                    <Badge>Design</Badge>
                                    <Badge>Technology</Badge>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <p class="text-sm font-medium">Secondary</p>
                                <div class="flex flex-wrap gap-2">
                                    <Badge variant="secondary">Secondary</Badge>
                                    <Badge variant="secondary">New</Badge>
                                    <Badge variant="secondary">Updated</Badge>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <p class="text-sm font-medium">Outline</p>
                                <div class="flex flex-wrap gap-2">
                                    <Badge variant="outline">Outline</Badge>
                                    <Badge variant="outline">
                                        <Tag class="mr-1 size-3" />
                                        Vue
                                    </Badge>
                                    <Badge variant="outline">
                                        <Tag class="mr-1 size-3" />
                                        React
                                    </Badge>
                                    <Badge variant="outline">
                                        <Tag class="mr-1 size-3" />
                                        Laravel
                                    </Badge>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <p class="text-sm font-medium">Destructive</p>
                                <div class="flex flex-wrap gap-2">
                                    <Badge variant="destructive"
                                        >Destructive</Badge
                                    >
                                    <Badge variant="destructive">Error</Badge>
                                    <Badge variant="destructive"
                                        >Critical</Badge
                                    >
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </section>

            <Separator />

            <!-- Inputs Section -->
            <section id="inputs" class="scroll-mt-6 space-y-6">
                <div>
                    <h2 class="mb-2 text-2xl font-bold">Form Inputs</h2>
                    <p class="text-muted-foreground">Champs de formulaire</p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Input Fields</CardTitle>
                        <CardDescription
                            >Différents types de champs</CardDescription
                        >
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <div class="space-y-2">
                            <Label for="text-input">Text Input</Label>
                            <Input
                                id="text-input"
                                placeholder="Enter text..."
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="email-input">Email Input</Label>
                            <Input
                                id="email-input"
                                type="email"
                                placeholder="email@example.com"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="search-input"
                                >Search Input with Icon</Label
                            >
                            <div class="relative">
                                <Search
                                    class="absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
                                />
                                <Input
                                    id="search-input"
                                    placeholder="Search articles..."
                                    class="pl-10"
                                />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <Label for="disabled-input">Disabled Input</Label>
                            <Input
                                id="disabled-input"
                                placeholder="Disabled"
                                disabled
                            />
                        </div>
                    </CardContent>
                </Card>
            </section>

            <Separator />

            <!-- Alerts Section -->
            <section id="alerts" class="scroll-mt-6 space-y-6">
                <div>
                    <h2 class="mb-2 text-2xl font-bold">Alerts</h2>
                    <p class="text-muted-foreground">
                        Messages et notifications
                    </p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Alert Variants</CardTitle>
                        <CardDescription
                            >Différents types d'alertes</CardDescription
                        >
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <Alert>
                            <Terminal class="size-4" />
                            <AlertTitle>Default Alert</AlertTitle>
                            <AlertDescription>
                                This is a default alert with an icon and
                                description.
                            </AlertDescription>
                        </Alert>

                        <Alert variant="destructive">
                            <AlertCircle class="size-4" />
                            <AlertTitle>Error Alert</AlertTitle>
                            <AlertDescription>
                                Something went wrong. Please try again later.
                            </AlertDescription>
                        </Alert>

                        <Alert>
                            <Info class="size-4" />
                            <AlertTitle>Information</AlertTitle>
                            <AlertDescription>
                                Your article has been saved successfully!
                            </AlertDescription>
                        </Alert>
                    </CardContent>
                </Card>
            </section>

            <Separator />

            <!-- Avatars Section -->
            <section id="avatars" class="scroll-mt-6 space-y-6">
                <div>
                    <h2 class="mb-2 text-2xl font-bold">Avatars</h2>
                    <p class="text-muted-foreground">Images de profil</p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Avatar Sizes</CardTitle>
                        <CardDescription
                            >Différentes tailles d'avatars</CardDescription
                        >
                    </CardHeader>
                    <CardContent>
                        <div class="flex flex-wrap items-center gap-6">
                            <div class="space-y-2">
                                <Avatar class="size-16">
                                    <AvatarImage
                                        src="https://github.com/shadcn.png"
                                        alt="User"
                                    />
                                    <AvatarFallback>JD</AvatarFallback>
                                </Avatar>
                                <p
                                    class="text-center text-xs text-muted-foreground"
                                >
                                    Large
                                </p>
                            </div>

                            <div class="space-y-2">
                                <Avatar class="size-12">
                                    <AvatarImage
                                        src="https://github.com/shadcn.png"
                                        alt="User"
                                    />
                                    <AvatarFallback>JD</AvatarFallback>
                                </Avatar>
                                <p
                                    class="text-center text-xs text-muted-foreground"
                                >
                                    Medium
                                </p>
                            </div>

                            <div class="space-y-2">
                                <Avatar class="size-8">
                                    <AvatarImage
                                        src="https://github.com/shadcn.png"
                                        alt="User"
                                    />
                                    <AvatarFallback>JD</AvatarFallback>
                                </Avatar>
                                <p
                                    class="text-center text-xs text-muted-foreground"
                                >
                                    Small
                                </p>
                            </div>

                            <div class="space-y-2">
                                <Avatar class="size-12">
                                    <AvatarFallback>AB</AvatarFallback>
                                </Avatar>
                                <p
                                    class="text-center text-xs text-muted-foreground"
                                >
                                    Fallback
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </section>

            <Separator />

            <!-- Skeletons & Loaders Section -->
            <section id="loading" class="scroll-mt-6 space-y-6">
                <div>
                    <h2 class="mb-2 text-2xl font-bold">Loading States</h2>
                    <p class="text-muted-foreground">Skeletons et spinners</p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Skeleton Loaders</CardTitle>
                        <CardDescription>États de chargement</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <div class="space-y-2">
                            <p class="text-sm font-medium">Card Skeleton</p>
                            <div class="space-y-3">
                                <Skeleton class="h-40 w-full" />
                                <Skeleton class="h-4 w-3/4" />
                                <Skeleton class="h-4 w-1/2" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <p class="text-sm font-medium">Spinners</p>
                            <div class="flex items-center gap-4">
                                <Spinner class="size-8" />
                                <Spinner class="size-6" />
                                <Spinner class="size-4" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <p class="text-sm font-medium">
                                Button with Spinner
                            </p>
                            <div class="flex gap-3">
                                <Button disabled>
                                    <Loader2 class="mr-2 size-4 animate-spin" />
                                    Loading...
                                </Button>
                                <Button variant="outline" disabled>
                                    <Loader2 class="mr-2 size-4 animate-spin" />
                                    Please wait
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </section>

            <Separator />

            <!-- Collapsible Section -->
            <section id="collapsible" class="scroll-mt-6 space-y-6">
                <div>
                    <h2 class="mb-2 text-2xl font-bold">Collapsible</h2>
                    <p class="text-muted-foreground">Contenu pliable</p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Collapsible Content</CardTitle>
                        <CardDescription
                            >Afficher/masquer du contenu</CardDescription
                        >
                    </CardHeader>
                    <CardContent>
                        <Collapsible
                            v-model:open="isCollapsibleOpen"
                            class="space-y-2"
                        >
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-semibold">
                                    Advanced Settings
                                </h4>
                                <CollapsibleTrigger as-child>
                                    <Button
                                        variant="ghost"
                                        size="sm"
                                        class="size-8 p-0"
                                    >
                                        <ChevronDown
                                            class="size-4 transition-transform duration-200"
                                            :class="
                                                isCollapsibleOpen
                                                    ? 'rotate-180'
                                                    : ''
                                            "
                                        />
                                    </Button>
                                </CollapsibleTrigger>
                            </div>
                            <div class="text-sm text-muted-foreground">
                                Click the chevron to expand additional settings.
                            </div>
                            <CollapsibleContent class="space-y-2">
                                <div class="rounded-md border px-4 py-3">
                                    <p class="text-sm">
                                        Setting 1: Enable notifications
                                    </p>
                                </div>
                                <div class="rounded-md border px-4 py-3">
                                    <p class="text-sm">
                                        Setting 2: Auto-save articles
                                    </p>
                                </div>
                                <div class="rounded-md border px-4 py-3">
                                    <p class="text-sm">
                                        Setting 3: Dark mode preference
                                    </p>
                                </div>
                            </CollapsibleContent>
                        </Collapsible>
                    </CardContent>
                </Card>
            </section>

            <Separator />

            <!-- Icons Section -->
            <section id="icons" class="scroll-mt-6 space-y-6">
                <div>
                    <h2 class="mb-2 text-2xl font-bold">Icons</h2>
                    <p class="text-muted-foreground">
                        Icônes Lucide utilisées dans l'app
                    </p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Common Icons</CardTitle>
                        <CardDescription
                            >Icônes fréquemment utilisées</CardDescription
                        >
                    </CardHeader>
                    <CardContent>
                        <div
                            class="grid grid-cols-4 gap-6 md:grid-cols-6 lg:grid-cols-8"
                        >
                            <div class="flex flex-col items-center gap-2">
                                <Bookmark class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Bookmark</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Star class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Star</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Heart class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Heart</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Search class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Search</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Plus class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Plus</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Settings class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Settings</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Tag class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Tag</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Clock class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Clock</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Calendar class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Calendar</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Archive class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Archive</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Rss class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >RSS</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <ExternalLink class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >External</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Grid3x3 class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Grid</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <List class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >List</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <User class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >User</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Mail class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Mail</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Home class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Home</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Trash2 class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Trash</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Check class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Check</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <X class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Close</span
                                >
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <Zap class="size-6" />
                                <span class="text-xs text-muted-foreground"
                                    >Zap</span
                                >
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </section>

            <Separator />

            <!-- Article Cards Section -->
            <section id="articles" class="scroll-mt-6 space-y-6">
                <div>
                    <h2 class="mb-2 text-2xl font-bold">Article Components</h2>
                    <p class="text-muted-foreground">
                        Composants pour afficher les articles sauvegardés
                    </p>
                </div>

                <!-- View Mode Toggle -->
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Grid View</h3>
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

                <!-- Grid View -->
                <div
                    v-if="viewMode === 'grid'"
                    class="grid gap-6 md:grid-cols-2 lg:grid-cols-3"
                >
                    <Card
                        v-for="article in articles"
                        :key="article.id"
                        class="group overflow-hidden transition-all hover:shadow-lg"
                        :class="article.isRead ? 'opacity-60' : ''"
                    >
                        <div
                            class="relative aspect-video overflow-hidden bg-muted"
                        >
                            <img
                                :src="article.image"
                                :alt="article.title"
                                class="size-full object-cover transition-transform duration-300 group-hover:scale-105"
                            />
                            <div class="absolute top-2 right-2 flex gap-2">
                                <Button
                                    size="sm"
                                    variant="secondary"
                                    class="size-8 rounded-full p-0 shadow-md"
                                >
                                    <Star
                                        class="size-4"
                                        :class="
                                            article.isStarred
                                                ? 'fill-yellow-400 text-yellow-400'
                                                : ''
                                        "
                                    />
                                </Button>
                                <Button
                                    size="sm"
                                    variant="secondary"
                                    class="size-8 rounded-full p-0 shadow-md"
                                >
                                    <Bookmark class="size-4" />
                                </Button>
                            </div>
                        </div>

                        <CardHeader class="pb-3">
                            <div class="flex items-start justify-between gap-2">
                                <Badge variant="secondary" class="mb-2">
                                    {{ article.category }}
                                </Badge>
                            </div>
                            <CardTitle
                                class="line-clamp-2 text-lg leading-tight"
                            >
                                {{ article.title }}
                            </CardTitle>
                            <CardDescription class="line-clamp-2 text-sm">
                                {{ article.excerpt }}
                            </CardDescription>
                        </CardHeader>

                        <CardContent class="pt-0">
                            <div
                                class="flex flex-wrap gap-2 border-t border-border pt-3"
                            >
                                <Badge
                                    v-for="tag in article.tags"
                                    :key="tag"
                                    variant="outline"
                                    class="text-xs"
                                >
                                    <Tag class="mr-1 size-3" />
                                    {{ tag }}
                                </Badge>
                            </div>

                            <div
                                class="mt-4 flex items-center justify-between text-sm text-muted-foreground"
                            >
                                <div class="flex items-center gap-1">
                                    <Clock class="size-3.5" />
                                    <span>{{ article.readTime }} min</span>
                                </div>
                                <span>{{ article.savedAt }}</span>
                            </div>

                            <Button
                                variant="ghost"
                                size="sm"
                                class="mt-3 w-full"
                            >
                                <ExternalLink class="mr-2 size-4" />
                                Open Article
                            </Button>
                        </CardContent>
                    </Card>
                </div>

                <!-- List View -->
                <div v-else class="flex flex-col gap-4">
                    <Card
                        v-for="article in articles"
                        :key="article.id"
                        class="group transition-all hover:shadow-md"
                        :class="article.isRead ? 'opacity-60' : ''"
                    >
                        <CardContent class="p-4">
                            <div class="flex gap-4">
                                <div
                                    class="relative size-32 flex-shrink-0 overflow-hidden rounded-lg bg-muted"
                                >
                                    <img
                                        :src="article.image"
                                        :alt="article.title"
                                        class="size-full object-cover transition-transform duration-300 group-hover:scale-105"
                                    />
                                </div>

                                <div
                                    class="flex flex-1 flex-col justify-between"
                                >
                                    <div>
                                        <div
                                            class="mb-2 flex items-center gap-2"
                                        >
                                            <Badge
                                                variant="secondary"
                                                class="text-xs"
                                            >
                                                {{ article.category }}
                                            </Badge>
                                            <span
                                                class="text-xs text-muted-foreground"
                                                >{{ article.savedAt }}</span
                                            >
                                        </div>
                                        <h3
                                            class="mb-2 line-clamp-1 text-lg font-semibold"
                                        >
                                            {{ article.title }}
                                        </h3>
                                        <p
                                            class="line-clamp-2 text-sm text-muted-foreground"
                                        >
                                            {{ article.excerpt }}
                                        </p>
                                    </div>

                                    <div
                                        class="mt-3 flex items-center justify-between"
                                    >
                                        <div class="flex flex-wrap gap-2">
                                            <Badge
                                                v-for="tag in article.tags.slice(
                                                    0,
                                                    2,
                                                )"
                                                :key="tag"
                                                variant="outline"
                                                class="text-xs"
                                            >
                                                {{ tag }}
                                            </Badge>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex items-center gap-1 text-xs text-muted-foreground"
                                            >
                                                <Clock class="size-3.5" />
                                                <span
                                                    >{{
                                                        article.readTime
                                                    }}
                                                    min</span
                                                >
                                            </div>
                                            <Button
                                                size="sm"
                                                variant="ghost"
                                                class="size-8 p-0"
                                            >
                                                <Star
                                                    class="size-4"
                                                    :class="
                                                        article.isStarred
                                                            ? 'fill-yellow-400 text-yellow-400'
                                                            : ''
                                                    "
                                                />
                                            </Button>
                                            <Button size="sm" variant="outline">
                                                <ExternalLink
                                                    class="mr-2 size-4"
                                                />
                                                Open
                                            </Button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle
                            >Article Card - Skeleton Loading State</CardTitle
                        >
                        <CardDescription
                            >État de chargement pour les
                            articles</CardDescription
                        >
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <div v-for="i in 3" :key="i" class="space-y-3">
                                <Skeleton class="aspect-video w-full" />
                                <Skeleton class="h-4 w-3/4" />
                                <Skeleton class="h-4 w-full" />
                                <Skeleton class="h-4 w-2/3" />
                                <div class="flex gap-2">
                                    <Skeleton class="h-5 w-16" />
                                    <Skeleton class="h-5 w-16" />
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </section>

            <Separator />

            <!-- Color Palette Section -->
            <section id="colors" class="scroll-mt-6 space-y-6">
                <div>
                    <h2 class="mb-2 text-2xl font-bold">Color Palette</h2>
                    <p class="text-muted-foreground">
                        Palette de couleurs du thème
                    </p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Theme Colors</CardTitle>
                        <CardDescription
                            >Couleurs utilisées dans
                            l'application</CardDescription
                        >
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <div class="space-y-2">
                                <div
                                    class="h-20 rounded-lg border bg-background"
                                ></div>
                                <p class="text-sm font-medium">Background</p>
                                <code class="text-xs text-muted-foreground"
                                    >bg-background</code
                                >
                            </div>
                            <div class="space-y-2">
                                <div
                                    class="h-20 rounded-lg border bg-foreground"
                                ></div>
                                <p class="text-sm font-medium">Foreground</p>
                                <code class="text-xs text-muted-foreground"
                                    >bg-foreground</code
                                >
                            </div>
                            <div class="space-y-2">
                                <div
                                    class="h-20 rounded-lg border bg-primary"
                                ></div>
                                <p class="text-sm font-medium">Primary</p>
                                <code class="text-xs text-muted-foreground"
                                    >bg-primary</code
                                >
                            </div>
                            <div class="space-y-2">
                                <div
                                    class="h-20 rounded-lg border bg-secondary"
                                ></div>
                                <p class="text-sm font-medium">Secondary</p>
                                <code class="text-xs text-muted-foreground"
                                    >bg-secondary</code
                                >
                            </div>
                            <div class="space-y-2">
                                <div
                                    class="h-20 rounded-lg border bg-muted"
                                ></div>
                                <p class="text-sm font-medium">Muted</p>
                                <code class="text-xs text-muted-foreground"
                                    >bg-muted</code
                                >
                            </div>
                            <div class="space-y-2">
                                <div
                                    class="h-20 rounded-lg border bg-accent"
                                ></div>
                                <p class="text-sm font-medium">Accent</p>
                                <code class="text-xs text-muted-foreground"
                                    >bg-accent</code
                                >
                            </div>
                            <div class="space-y-2">
                                <div
                                    class="h-20 rounded-lg border bg-destructive"
                                ></div>
                                <p class="text-sm font-medium">Destructive</p>
                                <code class="text-xs text-muted-foreground"
                                    >bg-destructive</code
                                >
                            </div>
                            <div class="space-y-2">
                                <div
                                    class="h-20 rounded-lg border bg-card"
                                ></div>
                                <p class="text-sm font-medium">Card</p>
                                <code class="text-xs text-muted-foreground"
                                    >bg-card</code
                                >
                            </div>
                            <div class="space-y-2">
                                <div
                                    class="h-20 rounded-lg border border-border bg-background"
                                ></div>
                                <p class="text-sm font-medium">Border</p>
                                <code class="text-xs text-muted-foreground"
                                    >border-border</code
                                >
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </section>

            <!-- Footer -->
            <div class="pt-4 pb-8">
                <Separator class="mb-6" />
                <div class="text-center text-sm text-muted-foreground">
                    <p>
                        Clipmark Design System - Built with Vue 3, Tailwind CSS,
                        and shadcn-vue
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
