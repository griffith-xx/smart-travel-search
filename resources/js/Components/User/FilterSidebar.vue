<script setup>
import { ref, computed } from "vue";
import { Slider, MultiSelect, Checkbox, Button } from "primevue";

const props = defineProps({
    filters: Object,
    filterOptions: Object,
    isMobileOpen: Boolean,
});

const emit = defineEmits(["close", "apply"]);

// Local filter state
const localFilters = ref({
    priceRange: [
        props.filters.price_min || 0,
        props.filters.price_max || props.filterOptions.priceRange.max,
    ],
    ratingMin: props.filters.rating_min || 0,
    selectedProvinces: props.filters.provinces || [],
    selectedCategories: props.filters.categories || [],
    selectedFeatures: props.filters.features || [],
});

// Feature definitions with Thai labels
const features = [
    { key: "parking", label: "ที่จอดรถ", icon: "pi-car" },
    { key: "wifi", label: "WiFi", icon: "pi-wifi" },
    { key: "restaurant", label: "ร้านอาหาร", icon: "pi-shopping-bag" },
    { key: "pet_friendly", label: "สัตว์เลี้ยงเข้าได้", icon: "pi-heart" },
    {
        key: "online_booking",
        label: "จองออนไลน์ได้",
        icon: "pi-calendar",
    },
    { key: "featured", label: "แนะนำพิเศษ", icon: "pi-star-fill" },
];

// Rating options
const ratingOptions = [
    { value: 0, label: "ทั้งหมด" },
    { value: 3, label: "3+ ดาว" },
    { value: 4, label: "4+ ดาว" },
    { value: 4.5, label: "4.5+ ดาว" },
];

const applyFilters = () => {
    emit("apply", {
        price_min:
            localFilters.value.priceRange[0] > 0
                ? localFilters.value.priceRange[0]
                : null,
        price_max:
            localFilters.value.priceRange[1] <
            props.filterOptions.priceRange.max
                ? localFilters.value.priceRange[1]
                : null,
        rating_min: localFilters.value.ratingMin || null,
        provinces: localFilters.value.selectedProvinces,
        categories: localFilters.value.selectedCategories,
        features: localFilters.value.selectedFeatures,
    });
    emit("close");
};

const clearAllFilters = () => {
    localFilters.value = {
        priceRange: [0, props.filterOptions.priceRange.max],
        ratingMin: 0,
        selectedProvinces: [],
        selectedCategories: [],
        selectedFeatures: [],
    };
    applyFilters();
};

const hasActiveFilters = computed(() => {
    return (
        localFilters.value.priceRange[0] > 0 ||
        localFilters.value.priceRange[1] <
            props.filterOptions.priceRange.max ||
        localFilters.value.ratingMin > 0 ||
        localFilters.value.selectedProvinces.length > 0 ||
        localFilters.value.selectedCategories.length > 0 ||
        localFilters.value.selectedFeatures.length > 0
    );
});
</script>

<template>
    <!-- Desktop Sidebar -->
    <div class="hidden lg:block w-80 flex-shrink-0">
        <div
            class="sticky top-4 bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
        >
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold">ตัวกรอง</h3>
                <Button
                    v-if="hasActiveFilters"
                    @click="clearAllFilters"
                    label="ล้างทั้งหมด"
                    text
                    size="small"
                />
            </div>

            <!-- Filter Sections -->
            <div class="space-y-6">
                <!-- Price Range -->
                <div>
                    <label class="text-sm font-medium mb-3 block"
                        >ช่วงราคา</label
                    >
                    <Slider
                        v-model="localFilters.priceRange"
                        :min="0"
                        :max="filterOptions.priceRange.max"
                        :step="100"
                        range
                        class="mb-4"
                    />
                    <div class="flex justify-between text-sm opacity-70">
                        <span
                            >฿{{
                                localFilters.priceRange[0].toLocaleString()
                            }}</span
                        >
                        <span
                            >฿{{
                                localFilters.priceRange[1].toLocaleString()
                            }}</span
                        >
                    </div>
                </div>

                <!-- Rating -->
                <div>
                    <label class="text-sm font-medium mb-3 block"
                        >คะแนนขั้นต่ำ</label
                    >
                    <div class="grid grid-cols-2 gap-2">
                        <button
                            v-for="option in ratingOptions"
                            :key="option.value"
                            @click="localFilters.ratingMin = option.value"
                            :class="[
                                'px-3 py-2 rounded-lg text-sm transition-all',
                                localFilters.ratingMin === option.value
                                    ? 'bg-[var(--p-primary-color)] text-white'
                                    : 'bg-surface-100 dark:bg-surface-800 hover:bg-surface-200 dark:hover:bg-surface-700',
                            ]"
                        >
                            {{ option.label }}
                        </button>
                    </div>
                </div>

                <!-- Provinces -->
                <div>
                    <label class="text-sm font-medium mb-3 block"
                        >จังหวัด</label
                    >
                    <MultiSelect
                        v-model="localFilters.selectedProvinces"
                        :options="filterOptions.provinces"
                        optionLabel="name"
                        optionValue="id"
                        placeholder="เลือกจังหวัด"
                        :maxSelectedLabels="2"
                        class="w-full"
                        filter
                    />
                </div>

                <!-- Categories -->
                <div>
                    <label class="text-sm font-medium mb-3 block"
                        >หมวดหมู่</label
                    >
                    <MultiSelect
                        v-model="localFilters.selectedCategories"
                        :options="filterOptions.categories"
                        optionLabel="name"
                        optionValue="id"
                        placeholder="เลือกหมวดหมู่"
                        :maxSelectedLabels="2"
                        class="w-full"
                    />
                </div>

                <!-- Features -->
                <div>
                    <label class="text-sm font-medium mb-3 block"
                        >สิ่งอำนวยความสะดวก</label
                    >
                    <div class="space-y-3">
                        <div
                            v-for="feature in features"
                            :key="feature.key"
                            class="flex items-center"
                        >
                            <Checkbox
                                v-model="localFilters.selectedFeatures"
                                :inputId="feature.key"
                                :value="feature.key"
                            />
                            <label
                                :for="feature.key"
                                class="ml-2 text-sm cursor-pointer flex items-center gap-2"
                            >
                                <i :class="`pi ${feature.icon} text-xs`"></i>
                                {{ feature.label }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apply Button -->
            <Button
                @click="applyFilters"
                label="ค้นหา"
                class="w-full mt-6"
            />
        </div>
    </div>

    <!-- Mobile Drawer -->
    <Transition name="fade">
        <div
            v-if="isMobileOpen"
            class="lg:hidden fixed inset-0 bg-black/50 z-50"
            @click="emit('close')"
        >
            <Transition name="slide">
                <div
                    v-if="isMobileOpen"
                    class="absolute right-0 top-0 bottom-0 w-full max-w-sm bg-[var(--p-content-background)] overflow-y-auto"
                    @click.stop
                >
                    <div class="p-6">
                        <!-- Header with close button -->
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold">ตัวกรอง</h3>
                            <div class="flex gap-2">
                                <Button
                                    v-if="hasActiveFilters"
                                    @click="clearAllFilters"
                                    label="ล้าง"
                                    text
                                    size="small"
                                />
                                <Button
                                    @click="emit('close')"
                                    icon="pi pi-times"
                                    text
                                    rounded
                                />
                            </div>
                        </div>

                        <!-- Same filter content as desktop -->
                        <div class="space-y-6">
                            <!-- Price Range -->
                            <div>
                                <label class="text-sm font-medium mb-3 block"
                                    >ช่วงราคา</label
                                >
                                <Slider
                                    v-model="localFilters.priceRange"
                                    :min="0"
                                    :max="filterOptions.priceRange.max"
                                    :step="100"
                                    range
                                    class="mb-4"
                                />
                                <div
                                    class="flex justify-between text-sm opacity-70"
                                >
                                    <span
                                        >฿{{
                                            localFilters.priceRange[0].toLocaleString()
                                        }}</span
                                    >
                                    <span
                                        >฿{{
                                            localFilters.priceRange[1].toLocaleString()
                                        }}</span
                                    >
                                </div>
                            </div>

                            <!-- Rating -->
                            <div>
                                <label class="text-sm font-medium mb-3 block"
                                    >คะแนนขั้นต่ำ</label
                                >
                                <div class="grid grid-cols-2 gap-2">
                                    <button
                                        v-for="option in ratingOptions"
                                        :key="option.value"
                                        @click="
                                            localFilters.ratingMin =
                                                option.value
                                        "
                                        :class="[
                                            'px-3 py-2 rounded-lg text-sm transition-all',
                                            localFilters.ratingMin ===
                                            option.value
                                                ? 'bg-[var(--p-primary-color)] text-white'
                                                : 'bg-surface-100 dark:bg-surface-800 hover:bg-surface-200 dark:hover:bg-surface-700',
                                        ]"
                                    >
                                        {{ option.label }}
                                    </button>
                                </div>
                            </div>

                            <!-- Provinces -->
                            <div>
                                <label class="text-sm font-medium mb-3 block"
                                    >จังหวัด</label
                                >
                                <MultiSelect
                                    v-model="localFilters.selectedProvinces"
                                    :options="filterOptions.provinces"
                                    optionLabel="name"
                                    optionValue="id"
                                    placeholder="เลือกจังหวัด"
                                    :maxSelectedLabels="2"
                                    class="w-full"
                                    filter
                                />
                            </div>

                            <!-- Categories -->
                            <div>
                                <label class="text-sm font-medium mb-3 block"
                                    >หมวดหมู่</label
                                >
                                <MultiSelect
                                    v-model="localFilters.selectedCategories"
                                    :options="filterOptions.categories"
                                    optionLabel="name"
                                    optionValue="id"
                                    placeholder="เลือกหมวดหมู่"
                                    :maxSelectedLabels="2"
                                    class="w-full"
                                    filter
                                />
                            </div>

                            <!-- Features -->
                            <div>
                                <label class="text-sm font-medium mb-3 block"
                                    >สิ่งอำนวยความสะดวก</label
                                >
                                <div class="space-y-3">
                                    <div
                                        v-for="feature in features"
                                        :key="feature.key"
                                        class="flex items-center"
                                    >
                                        <Checkbox
                                            v-model="
                                                localFilters.selectedFeatures
                                            "
                                            :inputId="feature.key"
                                            :value="feature.key"
                                        />
                                        <label
                                            :for="feature.key"
                                            class="ml-2 text-sm cursor-pointer flex items-center gap-2"
                                        >
                                            <i
                                                :class="
                                                    `pi ${feature.icon} text-xs`
                                                "
                                            ></i>
                                            {{ feature.label }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <Button
                            @click="applyFilters"
                            label="ค้นหา"
                            class="w-full mt-6"
                        />
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.3s;
}
.slide-enter-from,
.slide-leave-to {
    transform: translateX(100%);
}
</style>
