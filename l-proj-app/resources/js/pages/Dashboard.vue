<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { ShoppingCart } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Shopwindow',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Shop" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <div class="relative min-h-[50vh] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <img src="./assets/items/vacc.jpg">
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                        Sample Text <ShoppingCart />
                    </p>
                </div>
                <div class="relative min-h-[50vh] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <img src="./assets/items/vacc.jpg">
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                        Sample Text <ShoppingCart />
                    </p>
                </div>
                <div class="relative min-h-[50vh] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <img src="./assets/items/vacc.jpg">
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                        Sample Text <ShoppingCart />
                    </p>
                </div>
                <div class="relative min-h-[50vh] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <img src="./assets/items/vacc.jpg">
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                        Sample Text <ShoppingCart />
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
