<script setup>
import ThemeLayout from "./ThemeLayout.vue";
import { Head } from "@inertiajs/vue3";
defineProps({
    title: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head :title="title" />
    <ThemeLayout>
        <slot></slot>
    </ThemeLayout>
</template>
