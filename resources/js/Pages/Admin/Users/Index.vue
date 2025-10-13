<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Tag } from "primevue";
defineProps({
    users: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AdminLayout title="จัดการผู้ใช้">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-1">จัดการผู้ใช้</h1>
            <p class="text-sm opacity-75">
                จัดการผู้ใช้ทั้งหมด
                <Tag severity="info" class="ml-2"> {{ users.length }} คน </Tag>
            </p>
        </div>
    </AdminLayout>
</template>
