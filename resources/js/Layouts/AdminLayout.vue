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
        <Navigation />
        <div class="flex p-10 gap-10">
            <div>
                <Sidebar />
            </div>
            <slot></slot>
        </div>
    </AppLayout>
</template>
