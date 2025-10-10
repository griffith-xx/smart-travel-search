<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
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
                {{ users.length }} คน
            </p>
        </div>
    </AdminLayout>
</template>
