<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import {
    Button,
    DataTable,
    Column,
    ToggleSwitch,
    InputText,
    Tag,
    Select,
} from "primevue";
import { ref, computed } from "vue";

const props = defineProps({
    provinces: {
        type: Object,
        required: true,
    },
    regions: {
        type: Array,
        required: true,
    },
    regionsMap: {
        type: Object,
        required: true,
    },
});

const searchQuery = ref("");
const selectedRegion = ref(null);

const filteredProvinces = computed(() => {
    let filtered = props.provinces;

    // Filter by search query
    if (searchQuery.value) {
        filtered = filtered.filter(
            (province) =>
                province.name
                    .toLowerCase()
                    .includes(searchQuery.value.toLowerCase()) ||
                province.name_en
                    .toLowerCase()
                    .includes(searchQuery.value.toLowerCase())
        );
    }

    // Filter by region
    if (selectedRegion.value) {
        filtered = filtered.filter(
            (province) => province.region === selectedRegion.value
        );
    }

    return filtered;
});

const togglePopular = (id, value) => {
    router.put(
        route("admin.provinces.update", id),
        {
            is_popular: value,
        },
        {
            preserveScroll: true,
            preserveState: false,
        }
    );
};

const deleteProvince = (id) => {
    if (
        confirm(
            "คุณแน่ใจหรือไม่ที่จะลบจังหวัดนี้? การกระทำนี้ไม่สามารถย้อนกลับได้"
        )
    ) {
        router.delete(route("admin.provinces.destroy", id));
    }
};

const getRegionColor = (region) => {
    const colors = {
        north: "info",
        central: "success",
        south: "warn",
        northeast: "danger",
        east: "secondary",
        west: "contrast",
    };

    return colors[region] || "secondary";
};

const clearFilters = () => {
    searchQuery.value = "";
    selectedRegion.value = null;
};
</script>

<template>
    <AdminLayout title="จังหวัดทั้งหมด">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-3xl font-bold mb-1">จัดการจังหวัด</h1>
                    <p class="text-sm opacity-75">
                        จัดการข้อมูลจังหวัดทั้งหมด
                        {{ provinces.length }} จังหวัด
                    </p>
                </div>
                <Button asChild size="large" v-slot="slotProps">
                    <Link
                        :class="slotProps.class"
                        :href="route('admin.provinces.create')"
                    >
                        <i class="pi pi-plus mr-2"></i>
                        เพิ่มจังหวัดใหม่
                    </Link>
                </Button>
            </div>

            <!-- Filter Section -->
            <div class="card">
                <div class="flex gap-4 items-end">
                    <div class="flex-1">
                        <label
                            for="search"
                            class="block text-sm font-medium opacity-80 mb-2"
                        >
                            <i class="pi pi-search mr-1"></i>
                            ค้นหาจังหวัด
                        </label>
                        <InputText
                            id="search"
                            v-model="searchQuery"
                            placeholder="ค้นหาด้วยชื่อจังหวัด..."
                            class="w-full"
                        />
                    </div>

                    <div class="flex-1">
                        <label
                            for="region"
                            class="block text-sm font-medium opacity-80 mb-2"
                        >
                            <i class="pi pi-map-marker mr-1"></i>
                            กรองตามภูมิภาค
                        </label>
                        <Select
                            class="w-full"
                            v-model="selectedRegion"
                            placeholder="ทุกภูมิภาค"
                            :options="regions"
                            optionLabel="label"
                            optionValue="value"
                        />
                    </div>

                    <Button
                        v-if="searchQuery || selectedRegion"
                        severity="secondary"
                        @click="clearFilters"
                        icon="pi pi-filter-slash"
                        label="ล้างตัวกรอง"
                    />
                </div>

                <!-- Stats -->
                <div
                    class="flex gap-4 mt-4 pt-4 border-t border-[var(--p-menu-border-color)]"
                >
                    <div class="flex items-center gap-2">
                        <i class="pi pi-database text-blue-500"></i>
                        <span class="text-sm font-medium opacity-80">
                            <strong>{{ filteredProvinces.length }}</strong> จาก
                            {{ provinces.length }} จังหวัด
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="pi pi-star-fill text-yellow-500"></i>
                        <span class="text-sm font-medium opacity-80">
                            <strong>{{
                                provinces.filter((p) => p.is_popular).length
                            }}</strong>
                            ยอดนิยม
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card">
            <DataTable
                :value="filteredProvinces"
                paginator
                :rows="10"
                :rowsPerPageOptions="[10, 20, 50]"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                currentPageReportTemplate="แสดง {first} ถึง {last} จาก {totalRecords} รายการ"
                class="p-datatable-sm"
            >
                <Column field="id" header="#" sortable style="width: 5%">
                    <template #body="slotProps">
                        <span class="font-mono text-sm opacity-75">
                            #{{ slotProps.data.id }}
                        </span>
                    </template>
                </Column>

                <Column header="รูปภาพ" style="width: 12%">
                    <template #body="slotProps">
                        <div class="relative group">
                            <img
                                :src="slotProps.data.image_url"
                                :alt="slotProps.data.name"
                                class="w-20 h-14 object-cover rounded-lg"
                            />
                            <div
                                v-if="slotProps.data.is_popular"
                                class="absolute -top-2 -right-1 bg-yellow-400 rounded-full p-2 size-6 flex items-center justify-center"
                                title="ยอดนิยม"
                            >
                                <i
                                    class="pi pi-star-fill text-white text-xs"
                                ></i>
                            </div>
                        </div>
                    </template>
                </Column>

                <Column
                    header="ข้อมูลจังหวัด"
                    sortable
                    field="name"
                    style="width: 25%"
                >
                    <template #body="slotProps">
                        <div class="flex flex-col">
                            <div class="font-semibold text-base">
                                {{ slotProps.data.name }}
                            </div>
                            <div class="text-sm opacity-80">
                                {{ slotProps.data.name_en }}
                            </div>
                            <Tag
                                :severity="
                                    getRegionColor(slotProps.data.region)
                                "
                                class="w-fit mt-1"
                            >
                                {{ regionsMap[slotProps.data.region] }}
                            </Tag>
                        </div>
                    </template>
                </Column>

                <Column header="รายละเอียด" style="width: 30%">
                    <template #body="slotProps">
                        <div
                            class="line-clamp-2 text-sm opacity-75"
                            :title="slotProps.data.description"
                        >
                            {{
                                slotProps.data.description || "ไม่มีรายละเอียด"
                            }}
                        </div>
                    </template>
                </Column>

                <Column
                    header="สถานที่ท่องเที่ยว"
                    sortable
                    field="destinations_count"
                    style="width: 10%"
                >
                    <template #body="slotProps">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-map text-blue-500"></i>
                            <span class="font-semibold">
                                {{ slotProps.data.destinations_count || 0 }}
                            </span>
                            <span class="text-xs opacity-75">แห่ง</span>
                        </div>
                    </template>
                </Column>

                <Column header="พิกัด" style="width: 13%">
                    <template #body="slotProps">
                        <div class="text-xs font-mono opacity-75">
                            <div
                                v-if="
                                    slotProps.data.latitude &&
                                    slotProps.data.longitude
                                "
                            >
                                <div>{{ slotProps.data.latitude }}</div>
                                <div>{{ slotProps.data.longitude }}</div>
                            </div>
                            <div v-else class="text-red-500">ไม่มีข้อมูล</div>
                        </div>
                    </template>
                </Column>

                <Column header="การจัดการ" style="width: 15%">
                    <template #body="slotProps">
                        <div class="flex items-center justify-end gap-2">
                            <!-- Popular Toggle with better styling -->
                            <div
                                class="flex items-center gap-2 px-2 py-1 bg-surface-50 dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700"
                            >
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="text-xs font-medium opacity-75 whitespace-nowrap"
                                    >
                                        ยอดนิยม
                                    </span>
                                    <ToggleSwitch
                                        :modelValue="slotProps.data.is_popular"
                                        @update:modelValue="
                                            togglePopular(
                                                slotProps.data.id,
                                                $event
                                            )
                                        "
                                        size="small"
                                    />
                                </div>
                            </div>

                            <!-- Action Buttons with tooltips -->
                            <div class="flex gap-1">
                                <Button
                                    asChild
                                    severity="warn"
                                    size="small"
                                    v-slot="buttonProps"
                                >
                                    <Link
                                        :href="
                                            route(
                                                'admin.provinces.edit',
                                                slotProps.data.id
                                            )
                                        "
                                        :class="buttonProps.class"
                                    >
                                        <i class="pi pi-pencil"></i>
                                    </Link>
                                </Button>

                                <Button
                                    severity="danger"
                                    size="small"
                                    @click.prevent="
                                        deleteProvince(slotProps.data.id)
                                    "
                                    icon="pi pi-trash"
                                />
                            </div>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </AdminLayout>
</template>
