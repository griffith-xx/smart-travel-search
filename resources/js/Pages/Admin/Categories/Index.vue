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
} from "primevue";
import { ref, computed } from "vue";

const props = defineProps({
    categories: {
        type: Object,
        required: true,
    },
});

const searchQuery = ref("");

const filteredCategories = computed(() => {
    let filtered = props.categories;

    if (searchQuery.value) {
        filtered = filtered.filter(
            (category) =>
                category.name
                    .toLowerCase()
                    .includes(searchQuery.value.toLowerCase()) ||
                category.name_en
                    .toLowerCase()
                    .includes(searchQuery.value.toLowerCase())
        );
    }

    return filtered;
});

const togglePopular = (id, value) => {
    router.put(
        route("admin.categories.update", id),
        {
            is_popular: value,
        },
        {
            preserveScroll: true,
            preserveState: false,
        }
    );
};

const deleteCategory = (id) => {
    if (
        confirm(
            "คุณแน่ใจหรือไม่ที่จะลบหมวดหมู่นี้? การกระทำนี้ไม่สามารถย้อนกลับได้"
        )
    ) {
        router.delete(route("admin.categories.destroy", id));
    }
};

const clearFilters = () => {
    searchQuery.value = "";
};
</script>

<template>
    <AdminLayout title="หมวดหมู่ทั้งหมด">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-3xl font-bold mb-1">จัดการหมวดหมู่</h1>
                    <p class="text-sm opacity-75">
                        จัดการข้อมูลหมวดหมู่ทั้งหมด
                        <Tag severity="info" class="ml-2">
                            {{ categories.length }} หมวดหมู่
                        </Tag>
                    </p>
                </div>
                <Button asChild size="large" v-slot="slotProps">
                    <Link
                        :class="slotProps.class"
                        :href="route('admin.categories.create')"
                    >
                        <i class="pi pi-plus mr-2"></i>
                        เพิ่มหมวดหมู่ใหม่
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
                            ค้นหาหมวดหมู่
                        </label>
                        <InputText
                            id="search"
                            v-model="searchQuery"
                            placeholder="ค้นหาด้วยชื่อหมวดหมู่..."
                            class="w-full"
                        />
                    </div>

                    <Button
                        v-if="searchQuery"
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
                            <strong>{{ filteredCategories.length }}</strong> จาก
                            {{ categories.length }} หมวดหมู่
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="pi pi-star-fill text-yellow-500"></i>
                        <span class="text-sm font-medium opacity-80">
                            <strong>{{
                                categories.filter((p) => p.is_popular).length
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
                :value="filteredCategories"
                paginator
                :rows="10"
                :rowsPerPageOptions="[10, 20, 50]"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                currentPageReportTemplate="แสดง {first} ถึง {last} จาก {totalRecords} รายการ"
                class="p-datatable-sm"
            >
                <Column field="id" header="#" sortable>
                    <template #body="slotProps">
                        <span class="font-mono text-sm opacity-75">
                            #{{ slotProps.data.id }}
                        </span>
                    </template>
                </Column>

                <Column header="รูปภาพ">
                    <template #body="slotProps">
                        <div class="relative group">
                            <img
                                :src="slotProps.data.image_url"
                                :alt="slotProps.data.name"
                                class="w-20 h-14 object-cover rounded-lg"
                            />
                            <div
                                v-if="slotProps.data.is_popular"
                                class="absolute top-2 -right-1 bg-yellow-400 rounded-full p-2 size-6 flex items-center justify-center"
                                title="ยอดนิยม"
                            >
                                <i
                                    class="pi pi-star-fill text-white text-xs"
                                ></i>
                            </div>
                        </div>
                    </template>
                </Column>

                <Column header="ข้อมูลหมวดหมู่" sortable field="name">
                    <template #body="slotProps">
                        <div class="flex flex-col">
                            <div class="font-semibold text-base">
                                {{ slotProps.data.name }}
                            </div>
                            <div class="text-sm opacity-80">
                                {{ slotProps.data.name_en }}
                            </div>
                        </div>
                    </template>
                </Column>

                <Column header="รายละเอียด">
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

                <Column header="การจัดการ">
                    <template #body="slotProps">
                        <div class="flex items-center justify-start gap-2">
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
                                                'admin.categories.edit',
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
                                        deleteCategory(slotProps.data.id)
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
