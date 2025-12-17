<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import DestinationCard from "@/Components/User/DestinationCard.vue";
import FilterSidebar from "@/Components/User/FilterSidebar.vue";
import { Button, InputText, Select } from "primevue";
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
    filterOptions: {
        type: Object,
        required: true,
    },
});

const search = ref(props.filters.search || "");
const sortBy = ref(props.filters.sort || "latest");
const isMobileFilterOpen = ref(false);

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

const applyFilters = (additionalFilters = {}) => {
    router.get(
        route("destinations.index"),
        {
            search: search.value,
            sort: sortBy.value,
            ...additionalFilters,
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

const removeFilter = (filterType, value = null) => {
    const currentFilters = { ...props.filters };

    switch (filterType) {
        case "price":
            delete currentFilters.price_min;
            delete currentFilters.price_max;
            break;
        case "rating":
            delete currentFilters.rating_min;
            break;
        case "province":
            currentFilters.provinces = currentFilters.provinces.filter(
                (id) => id !== value
            );
            break;
        case "category":
            currentFilters.categories = currentFilters.categories.filter(
                (id) => id !== value
            );
            break;
        case "feature":
            currentFilters.features = currentFilters.features.filter(
                (f) => f !== value
            );
            break;
    }

    router.get(
        route("destinations.index"),
        {
            search: search.value,
            sort: sortBy.value,
            ...currentFilters,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

const getFeatureLabel = (feature) => {
    const labels = {
        parking: "ที่จอดรถ",
        wifi: "WiFi",
        restaurant: "ร้านอาหาร",
        pet_friendly: "สัตว์เลี้ยงเข้าได้",
        online_booking: "จองออนไลน์ได้",
        featured: "แนะนำพิเศษ",
    };
    return labels[feature] || feature;
};

const getFeatureIcon = (feature) => {
    const icons = {
        parking: "pi-car",
        wifi: "pi-wifi",
        restaurant: "pi-shopping-bag",
        pet_friendly: "pi-heart",
        online_booking: "pi-calendar",
        featured: "pi-star-fill",
    };
    return icons[feature] || "pi-tag";
};

const hasFilters = computed(() => {
    return (
        search.value ||
        sortBy.value !== "latest" ||
        props.filters.price_min ||
        props.filters.price_max ||
        props.filters.rating_min ||
        (props.filters.provinces && props.filters.provinces.length > 0) ||
        (props.filters.categories && props.filters.categories.length > 0) ||
        (props.filters.features && props.filters.features.length > 0)
    );
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
                        <Select
                            v-model="sortBy"
                            :options="sortOptions"
                            optionLabel="label"
                            optionValue="value"
                            placeholder="เรียงตาม"
                            class="w-full sm:w-48"
                            @change="applyFilters"
                        />

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

        <!-- Main Content with Sidebar Layout -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex gap-6">
                <!-- Filter Sidebar -->
                <FilterSidebar
                    :filters="filters"
                    :filter-options="filterOptions"
                    :is-mobile-open="isMobileFilterOpen"
                    @apply="applyFilters"
                    @close="isMobileFilterOpen = false"
                />

                <!-- Main Content -->
                <div class="flex-1 min-w-0">
                    <!-- Mobile filter button -->
                    <div class="lg:hidden mb-4">
                        <Button
                            @click="isMobileFilterOpen = true"
                            icon="pi pi-filter"
                            label="ตัวกรอง"
                            outlined
                            class="w-full"
                        />
                    </div>

                    <!-- Active filter chips -->
                    <div v-if="hasFilters" class="mb-6 flex flex-wrap gap-2">
                        <!-- Price chip -->
                        <div
                            v-if="filters.price_min || filters.price_max"
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-[var(--p-primary-color)]/10 text-[var(--p-primary-color)] rounded-full text-sm"
                        >
                            <i class="pi pi-tag text-xs"></i>
                            <span>
                                ฿{{
                                    (filters.price_min || 0).toLocaleString()
                                }}
                                -
                                ฿{{
                                    (
                                        filters.price_max ||
                                        filterOptions.priceRange.max
                                    ).toLocaleString()
                                }}
                            </span>
                            <button @click="removeFilter('price')">
                                <i
                                    class="pi pi-times text-xs hover:opacity-70"
                                ></i>
                            </button>
                        </div>

                        <!-- Rating chip -->
                        <div
                            v-if="filters.rating_min"
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-[var(--p-primary-color)]/10 text-[var(--p-primary-color)] rounded-full text-sm"
                        >
                            <i class="pi pi-star-fill text-xs"></i>
                            <span>{{ filters.rating_min }}+ ดาว</span>
                            <button @click="removeFilter('rating')">
                                <i
                                    class="pi pi-times text-xs hover:opacity-70"
                                ></i>
                            </button>
                        </div>

                        <!-- Province chips -->
                        <div
                            v-for="provinceId in filters.provinces"
                            :key="`province-${provinceId}`"
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-[var(--p-primary-color)]/10 text-[var(--p-primary-color)] rounded-full text-sm"
                        >
                            <i class="pi pi-map-marker text-xs"></i>
                            <span>{{
                                filterOptions.provinces.find(
                                    (p) => p.id === provinceId
                                )?.name
                            }}</span>
                            <button @click="removeFilter('province', provinceId)">
                                <i
                                    class="pi pi-times text-xs hover:opacity-70"
                                ></i>
                            </button>
                        </div>

                        <!-- Category chips -->
                        <div
                            v-for="categoryId in filters.categories"
                            :key="`category-${categoryId}`"
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-[var(--p-primary-color)]/10 text-[var(--p-primary-color)] rounded-full text-sm"
                        >
                            <i class="pi pi-tag text-xs"></i>
                            <span>{{
                                filterOptions.categories.find(
                                    (c) => c.id === categoryId
                                )?.name
                            }}</span>
                            <button @click="removeFilter('category', categoryId)">
                                <i
                                    class="pi pi-times text-xs hover:opacity-70"
                                ></i>
                            </button>
                        </div>

                        <!-- Feature chips -->
                        <div
                            v-for="feature in filters.features"
                            :key="`feature-${feature}`"
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-[var(--p-primary-color)]/10 text-[var(--p-primary-color)] rounded-full text-sm"
                        >
                            <i
                                :class="`pi ${getFeatureIcon(feature)} text-xs`"
                            ></i>
                            <span>{{ getFeatureLabel(feature) }}</span>
                            <button @click="removeFilter('feature', feature)">
                                <i
                                    class="pi pi-times text-xs hover:opacity-70"
                                ></i>
                            </button>
                        </div>
                    </div>

                    <!-- Results Count -->
                    <div class="mb-6">
                        <p class="text-sm opacity-70">
                            พบ
                            <span class="font-semibold">{{
                                destinations.total
                            }}</span>
                            สถานที่
                        </p>
                    </div>

                    <!-- Destinations Grid -->
                    <div
                        v-if="destinations.data.length > 0"
                        class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-8"
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
                        class="text-center py-16 bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700"
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
                            destinations.data.length > 0 &&
                            destinations.last_page > 1
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
                            >
                                <span v-html="link.label"> </span>
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
