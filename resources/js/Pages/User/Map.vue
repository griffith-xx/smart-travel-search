<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";

const props = defineProps({
    destinations: {
        type: Object,
        default: null,
    },
});
</script>

<template>
    <UserLayout title="แผนที่"> </UserLayout>
</template>
