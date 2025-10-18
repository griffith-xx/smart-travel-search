<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
defineProps({
    destination: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <UserLayout :title="destination.name">
        {{ destination }}
    </UserLayout>
</template>
