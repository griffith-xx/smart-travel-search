<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { Button } from "primevue";

defineProps({
    destinations: {
        type: Object,
        required: true,
    },
});

const deleteDestinations = (id) => {
    if (confirm("ยืนยันการลบ?")) {
        router.delete(route("admin.destinations.destroy", id));
    }
};
</script>

<template>
    <AdminLayout title="สถานที่ท่องเที่ยวทั้งหมด">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-3xl font-bold mb-1">จัดการสถานที่ท่องเที่ยว</h1>
                <p class="text-sm opacity-75">
                    จัดการข้อมูลสถานที่ท่องเที่ยวทั้งหมด
                    {{ destinations.length }} แห่ง
                </p>
            </div>
            <Button asChild size="large" v-slot="slotProps">
                <Link
                    :class="slotProps.class"
                    :href="route('admin.destinations.create')"
                >
                    <i class="pi pi-plus mr-2"></i>
                    เพิ่มสถานที่ท่องเที่ยว
                </Link>
            </Button>
        </div>
    </AdminLayout>
</template>
