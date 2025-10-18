<script setup>
import AppLayout from "./AppLayout.vue";
import Navigation from "@/Components/User/Navigation.vue";

defineProps({
    title: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <AppLayout :title="title">
        <div class="min-h-screen flex flex-col ">
            <!-- Navigation -->
            <Navigation />

            <!-- Main Content -->
            <main class="flex-1">
                <slot></slot>
            </main>

            <!-- Footer (Optional) -->
            <footer
                class="bg-[var(--p-content-background)] border-t border-surface-300 dark:border-surface-700 py-6"
            >
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="text-center md:text-left">
                            <p class="text-sm opacity-70">
                                © 2025 Smart Travel. All rights reserved.
                            </p>
                        </div>
                        <div class="flex items-center gap-4">
                            <a
                                href="#"
                                class="text-sm opacity-70 hover:opacity-100 transition"
                            >
                                เกี่ยวกับเรา
                            </a>
                            <span class="opacity-30">|</span>
                            <a
                                href="#"
                                class="text-sm opacity-70 hover:opacity-100 transition"
                            >
                                ติดต่อเรา
                            </a>
                            <span class="opacity-30">|</span>
                            <a
                                href="#"
                                class="text-sm opacity-70 hover:opacity-100 transition"
                            >
                                นโยบายความเป็นส่วนตัว
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </AppLayout>
</template>
