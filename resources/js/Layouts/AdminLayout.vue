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
        <div class="max-h-screen overflow-hidden">
            <Navigation />
            <div class="flex p-5 gap-5">
                <Sidebar />
                <div class="card max-h-screen overflow-y-auto">
                    <slot></slot>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
