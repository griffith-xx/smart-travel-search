<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import DestinationCard from "@/Components/DestinationCard.vue";
import { router } from "@inertiajs/vue3";
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
        route("destinations.index", { page: event.page + 1 }),
        {},
        {
            preserveScroll: true,
            preserveState: true,
        }
    );
};
</script>

<template>
    <UserLayout title="สถานที่ท่องเที่ยวทั้งหมด">
        <div class="container">
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
    </UserLayout>
</template>
