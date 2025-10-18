<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import DestinationCard from "@/Components/User/DestinationCard.vue";
import { Button } from "primevue";
import { computed } from "vue";
import { router, Link } from "@inertiajs/vue3";

const props = defineProps({
    destinations: {
        type: Object,
        required: true,
    },
});

const hasDestinations = computed(
    () => props.destinations.data && props.destinations.data.length > 0
);
</script>

<template>
    <UserLayout title="สถานที่ที่บันทึกไว้">
        <!-- Hero Section -->
        <div
            class="bg-gradient-to-br from-pink-500 to-rose-600 text-white"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
                <div class="text-center max-w-3xl mx-auto">
                    <div class="mb-4">
                        <i class="pi pi-heart-fill text-5xl opacity-90"></i>
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                        สถานที่ที่บันทึกไว้
                    </h1>
                    <p class="text-lg md:text-xl opacity-90">
                        สถานที่ท่องเที่ยวที่คุณถูกใจและบันทึกไว้
                    </p>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <!-- Has Saved Destinations -->
            <div v-if="hasDestinations">
                <!-- Stats -->
                <div class="mb-8">
                    <div
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6 flex flex-col sm:flex-row items-center justify-between gap-4"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                class="w-16 h-16 rounded-full bg-pink-500/10 flex items-center justify-center"
                            >
                                <i
                                    class="pi pi-heart-fill text-3xl text-pink-500"
                                ></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">
                                    {{ destinations.total }} สถานที่
                                </h2>
                                <p class="text-sm opacity-70">
                                    ที่คุณบันทึกไว้ทั้งหมด
                                </p>
                            </div>
                        </div>

                        <Button
                            label="สำรวจสถานที่เพิ่มเติม"
                            severity="secondary"
                            outlined
                            asChild
                            v-slot="slotProps"
                        >
                            <Link
                                :class="slotProps.class"
                                :href="route('destinations.index')"
                            >
                                <i class="pi pi-compass"></i>
                                สำรวจสถานที่เพิ่มเติม
                            </Link>
                        </Button>
                    </div>
                </div>

                <!-- Destinations Grid -->
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8"
                >
                    <DestinationCard
                        v-for="destination in destinations.data"
                        :key="destination.id"
                        :destination="destination"
                    />
                </div>

                <!-- Pagination -->
                <div
                    v-if="destinations.data.length > 0 && destinations.last_page > 1"
                    class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 border-t border-surface-300 dark:border-surface-700"
                >
                    <!-- Page Info -->
                    <div class="text-sm opacity-70">
                        หน้า {{ destinations.current_page }} จาก
                        {{ destinations.last_page }}
                    </div>

                    <!-- Pagination Buttons -->
                    <div class="flex gap-2">
                        <Button
                            v-for="link in destinations.links"
                            :key="link.label"
                            :label="
                                link.label
                                    .replace('&laquo;', '')
                                    .replace('&raquo;', '')
                            "
                            :disabled="!link.url || link.active"
                            :severity="link.active ? 'primary' : 'secondary'"
                            :outlined="!link.active"
                            @click="
                                link.url &&
                                    router.get(
                                        link.url,
                                        {},
                                        { preserveState: true }
                                    )
                            "
                            size="small"
                        />
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else>
                <div
                    class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-8 md:p-12 text-center"
                >
                    <div
                        class="w-32 h-32 mx-auto mb-6 rounded-full bg-pink-500/10 flex items-center justify-center"
                    >
                        <i class="pi pi-heart text-6xl text-pink-500 opacity-50"></i>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold mb-3">
                        ยังไม่มีสถานที่ที่บันทึกไว้
                    </h2>

                    <p class="text-lg opacity-70 mb-8 max-w-2xl mx-auto">
                        เริ่มสำรวจสถานที่ท่องเที่ยวและกดปุ่ม
                        <i class="pi pi-heart"></i>
                        เพื่อบันทึกสถานที่ที่คุณชอบ
                    </p>

                    <!-- Features -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="flex flex-col items-center p-6 rounded-xl border border-surface-300 dark:border-surface-700 hover:bg-[var(--p-content-hover-background)] transition">
                            <div
                                class="w-16 h-16 rounded-full bg-blue-500/10 flex items-center justify-center mb-4"
                            >
                                <i class="pi pi-bookmark text-3xl text-blue-500"></i>
                            </div>
                            <h3 class="font-semibold mb-2">บันทึกง่าย</h3>
                            <p class="text-sm opacity-70 text-center">
                                กดปุ่มหัวใจเพื่อบันทึกสถานที่ที่ชอบ
                            </p>
                        </div>

                        <div class="flex flex-col items-center p-6 rounded-xl border border-surface-300 dark:border-surface-700 hover:bg-[var(--p-content-hover-background)] transition">
                            <div
                                class="w-16 h-16 rounded-full bg-green-500/10 flex items-center justify-center mb-4"
                            >
                                <i class="pi pi-sync text-3xl text-green-500"></i>
                            </div>
                            <h3 class="font-semibold mb-2">ซิงค์อัตโนมัติ</h3>
                            <p class="text-sm opacity-70 text-center">
                                เข้าถึงได้ทุกที่ทุกเวลา
                            </p>
                        </div>

                        <div class="flex flex-col items-center p-6 rounded-xl border border-surface-300 dark:border-surface-700 hover:bg-[var(--p-content-hover-background)] transition">
                            <div
                                class="w-16 h-16 rounded-full bg-purple-500/10 flex items-center justify-center mb-4"
                            >
                                <i class="pi pi-list text-3xl text-purple-500"></i>
                            </div>
                            <h3 class="font-semibold mb-2">จัดการง่าย</h3>
                            <p class="text-sm opacity-70 text-center">
                                เรียกดูและจัดการรายการของคุณ
                            </p>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <Button
                            label="สำรวจสถานที่ท่องเที่ยว"
                            size="large"
                            asChild
                            v-slot="slotProps"
                        >
                            <Link
                                :class="slotProps.class"
                                :href="route('destinations.index')"
                            >
                                <i class="pi pi-compass"></i>
                                สำรวจสถานที่ท่องเที่ยว
                            </Link>
                        </Button>

                        <Button
                            label="ดูสถานที่แนะนำ"
                            severity="secondary"
                            outlined
                            size="large"
                            asChild
                            v-slot="slotProps"
                        >
                            <Link
                                :class="slotProps.class"
                                :href="route('destinations.recommended')"
                            >
                                <i class="pi pi-star"></i>
                                ดูสถานที่แนะนำ
                            </Link>
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
