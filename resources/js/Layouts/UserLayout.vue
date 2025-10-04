<script setup>
import AppLayout from "./AppLayout.vue";
defineProps({
    title: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <AppLayout :title="title">
        <slot></slot>
    </AppLayout>
</template>
