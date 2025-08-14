<script setup>
import { initializeDefaultTheme } from "@/Composables/themeManager";
import { onMounted } from "vue";
onMounted(() => {
    initializeDefaultTheme();
});
</script>

<template>
    <slot></slot>
</template>
