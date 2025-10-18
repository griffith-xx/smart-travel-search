<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import DestinationCard from "@/Components/DestinationCard.vue";
import { Link, router } from "@inertiajs/vue3";
import Paginator from "primevue/paginator";
import { computed } from "vue";

const props = defineProps({
    destinations: {
        type: Object,
        required: true,
    },
});

const currentPage = computed(() => props.destinations.current_page);
const totalRecords = computed(() => props.destinations.total);
const perPage = computed(() => props.destinations.per_page);

const onPageChange = (event) => {
    router.get(
        route("destinations.saved", { page: event.page + 1 }),
        {},
        {
            preserveScroll: true,
            preserveState: true,
        }
    );
};
</script>

<template>
    <UserLayout title="สถานที่ท่องเที่ยวที่บันทึกไว้">
        <div class="container">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    สถานที่ที่บันทึกไว้
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    สถานที่ท่องเที่ยวที่คุณบันทึกไว้ทั้งหมด
                    {{ destinations.total }} แห่ง
                </p>
            </div>

            <div
                v-if="destinations.data.length === 0"
                class="flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 py-12 dark:border-gray-700"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mb-4 h-16 w-16 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                </svg>
                <h3
                    class="mb-2 text-lg font-semibold text-gray-900 dark:text-white"
                >
                    ยังไม่มีสถานที่ที่บันทึกไว้
                </h3>
                <p class="mb-4 text-gray-600 dark:text-gray-400">
                    เริ่มต้นค้นหาและบันทึกสถานที่ท่องเที่ยวที่คุณสนใจ
                </p>
                <Link
                    :href="route('destinations.index')"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700"
                >
                    ค้นหาสถานที่ท่องเที่ยว
                </Link>
            </div>

            <div v-else>
                <div
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                >
                    <DestinationCard
                        v-for="destination in destinations.data"
                        :key="destination.id"
                        :destination="destination"
                    />
                </div>

                <div v-if="destinations.last_page > 1" class="mt-8">
                    <Paginator
                        :rows="perPage"
                        :total-records="totalRecords"
                        :first="(currentPage - 1) * perPage"
                        @page="onPageChange"
                    />
                </div>
            </div>
        </div>
    </UserLayout>
</template>
