<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";

defineProps({
    destinations: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <UserLayout title="สถานที่ท่องเที่ยวที่แนะนำ">
        <pre>
            {{ destinations }}
        </pre>
    </UserLayout>
</template>
