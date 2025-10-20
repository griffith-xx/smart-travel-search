<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import DestinationCard from "@/Components/User/DestinationCard.vue";
import { Button, InputText } from "primevue";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    destinations: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const search = ref(props.filters.search || "");
const sortBy = ref(props.filters.sort || "latest");

const sortOptions = [
    { label: "ล่าสุด", value: "latest" },
    { label: "เก่าสุด", value: "oldest" },
    { label: "ชื่อ A-Z", value: "name_asc" },
    { label: "ชื่อ Z-A", value: "name_desc" },
    { label: "คะแนนสูงสุด", value: "rating_desc" },
    { label: "ยอดนิยม", value: "popular" },
    { label: "ราคาต่ำสุด", value: "price_asc" },
    { label: "ราคาสูงสุด", value: "price_desc" },
];

const applyFilters = () => {
    router.get(
        route("destinations.index"),
        {
            search: search.value,
            sort: sortBy.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

const clearFilters = () => {
    search.value = "";
    sortBy.value = "latest";
    router.get(route("destinations.index"), {}, { preserveState: false });
};

const hasFilters = computed(() => {
    return search.value || sortBy.value !== "latest";
});
</script>

<template>
    <UserLayout title="สำรวจสถานที่ท่องเที่ยว">
        <!-- Hero Section -->
        <div class="relative text-white overflow-hidden">
            <!-- Background Image -->
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="
                    background-image: url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=2070');
                "
            ></div>

            <!-- Black Opacity Overlay -->
            <div class="absolute inset-0 bg-black/60"></div>

            <!-- Content -->
            <div
                class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16"
            >
                <div class="text-center">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                        สำรวจสถานที่ท่องเที่ยว
                    </h1>
                    <p class="text-lg md:text-xl opacity-90 max-w-2xl mx-auto">
                        ค้นพบสถานที่ท่องเที่ยวที่น่าสนใจทั่วประเทศไทย
                    </p>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div
            class="bg-[var(--p-content-background)] border-b border-surface-300 dark:border-surface-700"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <InputText
                            v-model="search"
                            placeholder="ค้นหาสถานที่ท่องเที่ยว..."
                            class="w-full"
                            @keyup.enter="applyFilters"
                        >
                            <template #prepend>
                                <i class="pi pi-search"></i>
                            </template>
                        </InputText>
                    </div>

                    <!-- Sort -->
                    <div class="flex gap-2">
                       
                        <Button
                            @click="applyFilters"
                            icon="pi pi-filter"
                            label="ค้นหา"
                            class="hidden sm:flex"
                        />

                        <Button
                            @click="applyFilters"
                            icon="pi pi-filter"
                            class="sm:hidden"
                        />

                        <Button
                            v-if="hasFilters"
                            @click="clearFilters"
                            icon="pi pi-times"
                            severity="secondary"
                            outlined
                            v-tooltip.bottom="'ล้างตัวกรอง'"
                        />
                    </div>
                </div>

                <!-- Active Filters Display -->
                <div v-if="hasFilters" class="flex flex-wrap gap-2 mt-4">
                    <div
                        v-if="search"
                        class="inline-flex items-center gap-2 px-3 py-1 bg-[var(--p-primary-color)]/10 text-[var(--p-primary-color)] rounded-full text-sm"
                    >
                        <span>ค้นหา: {{ search }}</span>
                        <button
                            @click="
                                search = '';
                                applyFilters();
                            "
                        >
                            <i class="pi pi-times text-xs"></i>
                        </button>
                    </div>
                    <div
                        v-if="sortBy !== 'latest'"
                        class="inline-flex items-center gap-2 px-3 py-1 bg-[var(--p-primary-color)]/10 text-[var(--p-primary-color)] rounded-full text-sm"
                    >
                        <span>
                            เรียงตาม:
                            {{
                                sortOptions.find((o) => o.value === sortBy)
                                    ?.label
                            }}
                        </span>
                        <button
                            @click="
                                sortBy = 'latest';
                                applyFilters();
                            "
                        >
                            <i class="pi pi-times text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Results Count -->
            <div class="mb-6">
                <p class="text-sm opacity-70">
                    พบ
                    <span class="font-semibold">{{ destinations.total }}</span>
                    สถานที่
                </p>
            </div>

            <!-- Destinations Grid -->
            <div
                v-if="destinations.data.length > 0"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8"
            >
                <DestinationCard
                    v-for="destination in destinations.data"
                    :key="destination.id"
                    :destination="destination"
                />
            </div>

            <!-- Empty State -->
            <div
                v-else
                class="text-center py-16 bg-[var(--p-content-background)] rounded-xl border border-[var(--p-menu-border-color)]"
            >
                <div class="w-24 h-24 mx-auto mb-4 opacity-20">
                    <i class="pi pi-inbox text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">
                    ไม่พบสถานที่ท่องเที่ยว
                </h3>
                <p class="opacity-70 mb-6">
                    ลองเปลี่ยนคำค้นหาหรือตัวกรองของคุณ
                </p>
                <Button
                    @click="clearFilters"
                    label="ล้างตัวกรอง"
                    icon="pi pi-refresh"
                    severity="secondary"
                />
            </div>

            <!-- Pagination -->
            <div
                v-if="
                    destinations.data.length > 0 && destinations.last_page > 1
                "
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
    </UserLayout>
</template>
