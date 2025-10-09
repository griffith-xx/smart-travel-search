<script setup>
import AppLayout from "./AppLayout.vue";
import Sidebar from "@/Components/Admin/Sidebar.vue";
import Navigation from "@/Components/Admin/Navigation.vue";

defineProps({
    title: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <AppLayout :title="title">
        <div class="h-screen flex flex-col overflow-hidden">
            <div class="flex-shrink-0">
                <Navigation />
            </div>

            <div class="flex flex-1 overflow-hidden">
                <div class="flex-shrink-0 min-w-[250px]">
                    <Sidebar />
                </div>

                <div class="flex-1 overflow-y-auto p-6">
                    <slot></slot>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
