<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import {
    Button,
    DataTable,
    Column,
    Tag,
    InputText,
    IconField,
    InputIcon,
    ConfirmDialog,
    useConfirm,
    Card,
} from "primevue";
import { ref, computed } from "vue";

const props = defineProps({
    destinations: {
        type: Array,
        required: true,
    },
});

const confirm = useConfirm();
const searchQuery = ref("");

const filteredDestinations = computed(() => {
    if (!searchQuery.value) return props.destinations;

    const query = searchQuery.value.toLowerCase();
    return props.destinations.filter(
        (destination) =>
            destination.name.toLowerCase().includes(query) ||
            destination.name_en.toLowerCase().includes(query) ||
            destination.province.name.toLowerCase().includes(query)
    );
});

const deleteDestination = (destination) => {
    confirm.require({
        message: `ต้องการลบสถานที่ท่องเที่ยว "${destination.name}" ใช่หรือไม่?`,
        header: "ยืนยันการลบ",
        icon: "pi pi-exclamation-triangle",
        rejectLabel: "ยกเลิก",
        acceptLabel: "ลบ",
        rejectProps: {
            label: "ยกเลิก",
            severity: "secondary",
            outlined: true,
        },
        acceptProps: {
            label: "ลบ",
            severity: "danger",
        },
        accept: () => {
            router.delete(route("admin.destinations.destroy", destination.id));
        },
    });
};

const toggleActive = (destination) => {
    router.post(route("admin.destinations.toggle-active", destination.id));
};

const toggleFeatured = (destination) => {
    router.post(route("admin.destinations.toggle-featured", destination.id));
};

const getStatusSeverity = (isActive) => {
    return isActive ? "success" : "danger";
};

const getFeaturedSeverity = (isFeatured) => {
    return isFeatured ? "info" : "secondary";
};
</script>

<template>
    <AdminLayout title="สถานที่ท่องเที่ยวทั้งหมด">
        <ConfirmDialog />

        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold mb-1">
                    <i class="pi pi-map-marker mr-2"></i>
                    จัดการสถานที่ท่องเที่ยว
                </h1>
                <p class="text-sm opacity-75">
                    จัดการข้อมูลสถานที่ท่องเที่ยวทั้งหมด
                    <Tag severity="info" class="ml-2">
                        {{ destinations.length }} แห่ง
                    </Tag>
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

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 my-6">
            <Card
                class="shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-green-500"
            >
                <template #content>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-75 mb-2">
                                สถานที่เปิดใช้งาน
                            </p>
                            <p class="text-4xl font-bold text-green-600">
                                {{
                                    destinations.filter((d) => d.is_active)
                                        .length
                                }}
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-green-400 to-green-600 p-4 rounded-2xl shadow-lg"
                        >
                            <i
                                class="pi pi-check-circle text-white text-4xl"
                            ></i>
                        </div>
                    </div>
                </template>
            </Card>

            <Card
                class="shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-red-500"
            >
                <template #content>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-75 mb-2">
                                สถานที่ปิดใช้งาน
                            </p>
                            <p class="text-4xl font-bold text-red-600">
                                {{
                                    destinations.filter((d) => !d.is_active)
                                        .length
                                }}
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-red-400 to-red-600 p-4 rounded-2xl shadow-lg"
                        >
                            <i
                                class="pi pi-times-circle text-white text-4xl"
                            ></i>
                        </div>
                    </div>
                </template>
            </Card>

            <Card
                class="shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-blue-500"
            >
                <template #content>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-75 mb-2">
                                สถานที่แนะนำ
                            </p>
                            <p class="text-4xl font-bold text-blue-600">
                                {{
                                    destinations.filter((d) => d.is_featured)
                                        .length
                                }}
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-blue-400 to-blue-600 p-4 rounded-2xl shadow-lg"
                        >
                            <i class="pi pi-star-fill text-white text-4xl"></i>
                        </div>
                    </div>
                </template>
            </Card>

            <Card
                class="shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-purple-500"
            >
                <template #content>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-75 mb-2">
                                ยอดเข้าชมรวม
                            </p>
                            <p class="text-4xl font-bold text-purple-600">
                                {{
                                    destinations.reduce(
                                        (sum, d) => sum + (d.view_count || 0),
                                        0
                                    )
                                }}
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-purple-400 to-purple-600 p-4 rounded-2xl shadow-lg"
                        >
                            <i class="pi pi-eye text-white text-4xl"></i>
                        </div>
                    </div>
                </template>
            </Card>
        </div>

        <!-- Search Bar -->
        <div class="mb-4">
            <IconField>
                <InputIcon>
                    <i class="pi pi-search" />
                </InputIcon>
                <InputText
                    v-model="searchQuery"
                    placeholder="ค้นหาสถานที่ท่องเที่ยว, จังหวัด..."
                    class="w-full md:w-96"
                />
            </IconField>
        </div>

        <!-- Data Table -->
        <DataTable
            :value="filteredDestinations"
            paginator
            :rows="10"
            :rowsPerPageOptions="[5, 10, 20, 50]"
            tableStyle="min-width: 50rem"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            currentPageReportTemplate="แสดง {first} ถึง {last} จาก {totalRecords} รายการ"
            stripedRows
        >
            <!-- Cover Image Column -->
            <Column header="รูปภาพ" style="width: 200px">
                <template #body="{ data }">
                    <img
                        :src="data.cover_image"
                        :alt="data.name"
                        class="w-full h-30 object-cover rounded-lg shadow-sm"
                        @error="
                            $event.target.src =
                                'https://placehold.co/80x80?text=No+Image'
                        "
                    />
                </template>
            </Column>

            <!-- Name Column -->
            <Column field="name" header="ชื่อสถานที่" sortable>
                <template #body="{ data }">
                    <div>
                        <div class="font-semibold text-base mb-1">
                            {{ data.name }}
                        </div>
                        <div class="text-sm opacity-75">
                            {{ data.name_en }}
                        </div>
                    </div>
                </template>
            </Column>

            <!-- Province Column -->
            <Column header="จังหวัด" sortable>
                <template #body="{ data }">
                    <div class="flex items-center gap-2">
                        <i class="pi pi-map text-blue-500"></i>
                        <span>{{ data.province.name }}</span>
                    </div>
                </template>
            </Column>

            <!-- Category Column -->
            <Column header="หมวดหมู่" sortable>
                <template #body="{ data }">
                    <div class="flex items-center gap-2">
                        <i class="pi pi-folder text-violet-500"></i>
                        <span>{{ data.category.name }}</span>
                    </div>
                </template>
            </Column>

            <!-- Status Column -->
            <Column header="สถานะ" style="width: 120px">
                <template #body="{ data }">
                    <div class="flex flex-col gap-1">
                        <Tag
                            :severity="getStatusSeverity(data.is_active)"
                            class="cursor-pointer"
                            @click="toggleActive(data)"
                        >
                            <i
                                :class="
                                    data.is_active
                                        ? 'pi pi-check-circle'
                                        : 'pi pi-times-circle'
                                "
                                class="mr-1"
                            ></i>
                            {{ data.is_active ? "เปิดใช้งาน" : "ปิดใช้งาน" }}
                        </Tag>
                    </div>
                </template>
            </Column>

            <!-- Featured Column -->
            <Column header="แนะนำ" style="width: 100px">
                <template #body="{ data }">
                    <Tag
                        :severity="getFeaturedSeverity(data.is_featured)"
                        class="cursor-pointer"
                        @click="toggleFeatured(data)"
                    >
                        <i
                            :class="
                                data.is_featured
                                    ? 'pi pi-star-fill'
                                    : 'pi pi-star'
                            "
                            class="mr-1"
                        ></i>
                        {{ data.is_featured ? "แนะนำ" : "ทั่วไป" }}
                    </Tag>
                </template>
            </Column>

            <!-- Stats Column -->
            <Column header="สถิติ" style="width: 150px">
                <template #body="{ data }">
                    <div class="flex flex-col gap-1 text-sm">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-eye text-blue-500"></i>
                            <span>{{ data.view_count || 0 }} ครั้ง</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-heart text-red-500"></i>
                            <span>{{ data.like_count || 0 }} ไลค์</span>
                        </div>
                    </div>
                </template>
            </Column>

            <!-- Actions Column -->
            <Column header="จัดการ" style="width: 200px">
                <template #body="{ data }">
                    <div class="flex gap-2">
                        <Button
                            asChild
                            size="small"
                            severity="info"
                            v-slot="slotProps"
                        >
                            <Link
                                :class="slotProps.class"
                                :href="
                                    route('admin.destinations.show', data.id)
                                "
                            >
                                <i class="pi pi-eye"></i>
                            </Link>
                        </Button>

                        <Button
                            asChild
                            size="small"
                            severity="warn"
                            v-slot="slotProps"
                        >
                            <Link
                                :class="slotProps.class"
                                :href="
                                    route('admin.destinations.edit', data.id)
                                "
                            >
                                <i class="pi pi-pencil"></i>
                            </Link>
                        </Button>

                        <Button
                            asChild
                            size="small"
                            severity="help"
                            v-slot="slotProps"
                        >
                            <Link
                                :class="slotProps.class"
                                :href="
                                    route(
                                        'admin.destinations.preferences.edit',
                                        data.id
                                    )
                                "
                            >
                                <i class="pi pi-heart"></i>
                            </Link>
                        </Button>

                        <Button
                            size="small"
                            severity="danger"
                            @click="deleteDestination(data)"
                        >
                            <i class="pi pi-trash"></i>
                        </Button>
                    </div>
                </template>
            </Column>

            <!-- Empty State -->
            <template #empty>
                <div class="text-center py-8">
                    <i class="pi pi-inbox text-6xl opacity-25 mb-4"></i>
                    <p class="text-lg opacity-75">
                        ไม่พบข้อมูลสถานที่ท่องเที่ยว
                    </p>
                    <Button asChild class="mt-4" v-slot="slotProps">
                        <Link
                            :class="slotProps.class"
                            :href="route('admin.destinations.create')"
                        >
                            <i class="pi pi-plus mr-2"></i>
                            เพิ่มสถานที่ท่องเที่ยวแรก
                        </Link>
                    </Button>
                </div>
            </template>
        </DataTable>
    </AdminLayout>
</template>
