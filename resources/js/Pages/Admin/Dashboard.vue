<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link } from "@inertiajs/vue3";
import { Card, DataTable, Column, Tag, Button } from "primevue";

const props = defineProps({
    stats: {
        type: Object,
        required: true,
    },
    recentDestinations: {
        type: Array,
        required: true,
    },
    recentUsers: {
        type: Array,
        required: true,
    },
    topDestinations: {
        type: Array,
        required: true,
    },
});

const formatDate = (dateString) => {
    if (!dateString) return "-";
    const date = new Date(dateString);
    return new Intl.DateTimeFormat("th-TH", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    }).format(date);
};
</script>

<template>
    <AdminLayout title="Welcome To Nuxus">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-1">
                ยินดีต้อนรับ
                {{ $page.props.auth.user.name }}
            </h1>
            <p class="text-sm opacity-75">
                ภาพรวมข้อมูลและสถิติของระบบ Smart Travel Search
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- จังหวัดทั้งหมด -->
            <Card
                class="shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-blue-500"
            >
                <template #content>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-75 mb-2">
                                จังหวัดทั้งหมด
                            </p>
                            <p class="text-4xl font-bold text-blue-600 mb-2">
                                {{ stats.provinces.total }}
                            </p>
                            <p class="text-xs opacity-60">
                                <i class="pi pi-star-fill text-yellow-500 mr-1"></i>
                                {{ stats.provinces.popular }} จังหวัดยอดนิยม
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-blue-400 to-blue-600 p-4 rounded-2xl shadow-lg"
                        >
                            <i class="pi pi-map text-white text-4xl"></i>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- สถานที่ท่องเที่ยวทั้งหมด -->
            <Card
                class="shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-green-500"
            >
                <template #content>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-75 mb-2">
                                สถานที่ท่องเที่ยว
                            </p>
                            <p class="text-4xl font-bold text-green-600 mb-2">
                                {{ stats.destinations.total }}
                            </p>
                            <p class="text-xs opacity-60">
                                <i class="pi pi-check-circle text-green-500 mr-1"></i>
                                {{ stats.destinations.active }} แห่งเปิดใช้งาน
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-green-400 to-green-600 p-4 rounded-2xl shadow-lg"
                        >
                            <i class="pi pi-map-marker text-white text-4xl"></i>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- ผู้ใช้งานทั้งหมด -->
            <Card
                class="shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-purple-500"
            >
                <template #content>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-75 mb-2">
                                ผู้ใช้งาน
                            </p>
                            <p class="text-4xl font-bold text-purple-600 mb-2">
                                {{ stats.users.total }}
                            </p>
                            <p class="text-xs opacity-60">
                                <i class="pi pi-arrow-up text-green-500 mr-1"></i>
                                ผู้ใช้งานใหม่ {{ stats.users.new }} คน
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-purple-400 to-purple-600 p-4 rounded-2xl shadow-lg"
                        >
                            <i class="pi pi-users text-white text-4xl"></i>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- คอมเมนต์ทั้งหมด -->
            <Card
                class="shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-orange-500"
            >
                <template #content>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-75 mb-2">
                                คอมเมนต์ทั้งหมด
                            </p>
                            <p class="text-4xl font-bold text-orange-600 mb-2">
                                {{ stats.comments.total }}
                            </p>
                            <p class="text-xs opacity-60">
                                <i class="pi pi-arrow-up text-green-500 mr-1"></i>
                                คอมเมนต์ใหม่ {{ stats.comments.new }} รายการ
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-orange-400 to-orange-600 p-4 rounded-2xl shadow-lg"
                        >
                            <i class="pi pi-comment text-white text-4xl"></i>
                        </div>
                    </div>
                </template>
            </Card>
        </div>

        <!-- Additional Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- หมวดหมู่ -->
            <Card class="shadow-lg">
                <template #content>
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-br from-cyan-400 to-cyan-600 p-3 rounded-xl">
                            <i class="pi pi-th-large text-white text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm opacity-75">หมวดหมู่ทั้งหมด</p>
                            <p class="text-2xl font-bold text-cyan-600">
                                {{ stats.categories.total }}
                            </p>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- ไลค์ทั้งหมด -->
            <Card class="shadow-lg">
                <template #content>
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-br from-pink-400 to-pink-600 p-3 rounded-xl">
                            <i class="pi pi-heart-fill text-white text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm opacity-75">ไลค์ทั้งหมด</p>
                            <p class="text-2xl font-bold text-pink-600">
                                {{ stats.likes.total }}
                            </p>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- สถานที่แนะนำ -->
            <Card class="shadow-lg">
                <template #content>
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-br from-amber-400 to-amber-600 p-3 rounded-xl">
                            <i class="pi pi-star-fill text-white text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm opacity-75">สถานที่แนะนำ</p>
                            <p class="text-2xl font-bold text-amber-600">
                                {{ stats.destinations.featured }}
                            </p>
                        </div>
                    </div>
                </template>
            </Card>
        </div>

        <!-- Recent Data Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Recent Destinations -->
            <Card class="shadow-lg">
                <template #title>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-map-marker text-green-500"></i>
                            <span>สถานที่ท่องเที่ยวล่าสุด</span>
                        </div>
                        <Button asChild size="small" severity="secondary" v-slot="slotProps">
                            <Link :href="route('admin.destinations.index')" :class="slotProps.class">
                                ดูทั้งหมด
                            </Link>
                        </Button>
                    </div>
                </template>
                <template #content>
                    <DataTable :value="recentDestinations" class="p-datatable-sm">
                        <Column header="สถานที่" style="width: 50%">
                            <template #body="slotProps">
                                <div>
                                    <div class="font-semibold text-sm">
                                        {{ slotProps.data.name }}
                                    </div>
                                    <div class="text-xs opacity-75">
                                        {{ slotProps.data.province_name }}
                                    </div>
                                </div>
                            </template>
                        </Column>
                        <Column header="หมวดหมู่" style="width: 25%">
                            <template #body="slotProps">
                                <span class="text-xs opacity-75">
                                    {{ slotProps.data.category_name }}
                                </span>
                            </template>
                        </Column>
                        <Column header="สถานะ" style="width: 25%">
                            <template #body="slotProps">
                                <div class="flex gap-1">
                                    <Tag
                                        v-if="slotProps.data.is_active"
                                        severity="success"
                                        class="text-xs"
                                    >
                                        เปิดใช้งาน
                                    </Tag>
                                    <Tag
                                        v-if="slotProps.data.is_featured"
                                        severity="warn"
                                        class="text-xs"
                                    >
                                        แนะนำ
                                    </Tag>
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                </template>
            </Card>

            <!-- Recent Users -->
            <Card class="shadow-lg">
                <template #title>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-users text-purple-500"></i>
                            <span>ผู้ใช้งานล่าสุด</span>
                        </div>
                        <Button asChild size="small" severity="secondary" v-slot="slotProps">
                            <Link :href="route('admin.users.index')" :class="slotProps.class">
                                ดูทั้งหมด
                            </Link>
                        </Button>
                    </div>
                </template>
                <template #content>
                    <DataTable :value="recentUsers" class="p-datatable-sm">
                        <Column header="ผู้ใช้" style="width: 60%">
                            <template #body="slotProps">
                                <div class="flex items-center gap-3">
                                    <img
                                        :src="slotProps.data.profile_photo_url"
                                        :alt="slotProps.data.name"
                                        class="w-8 h-8 rounded-full"
                                    />
                                    <div>
                                        <div class="font-semibold text-sm">
                                            {{ slotProps.data.name }}
                                        </div>
                                        <div class="text-xs opacity-75">
                                            {{ slotProps.data.email }}
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </Column>
                        <Column header="วันที่สมัคร" style="width: 40%">
                            <template #body="slotProps">
                                <span class="text-xs opacity-75">
                                    {{ formatDate(slotProps.data.created_at) }}
                                </span>
                            </template>
                        </Column>
                    </DataTable>
                </template>
            </Card>
        </div>

        <!-- Top Liked Destinations -->
        <Card class="shadow-lg">
            <template #title>
                <div class="flex items-center gap-2">
                    <i class="pi pi-heart-fill text-pink-500"></i>
                    <span>สถานที่ท่องเที่ยวยอดนิยม (ตามไลค์)</span>
                </div>
            </template>
            <template #content>
                <DataTable :value="topDestinations" class="p-datatable-sm">
                    <Column field="id" header="#" style="width: 5%">
                        <template #body="slotProps">
                            <span class="font-mono text-sm opacity-75">
                                #{{ slotProps.data.id }}
                            </span>
                        </template>
                    </Column>
                    <Column header="รูปภาพ" style="width: 15%">
                        <template #body="slotProps">
                            <img
                                :src="slotProps.data.cover_image || '/placeholder.jpg'"
                                :alt="slotProps.data.name"
                                class="w-20 h-14 object-cover rounded-lg"
                            />
                        </template>
                    </Column>
                    <Column header="สถานที่" style="width: 45%">
                        <template #body="slotProps">
                            <div>
                                <div class="font-semibold">
                                    {{ slotProps.data.name }}
                                </div>
                                <div class="text-sm opacity-75">
                                    {{ slotProps.data.province_name }}
                                </div>
                            </div>
                        </template>
                    </Column>
                    <Column header="จำนวนไลค์" sortable field="likes_count" style="width: 15%">
                        <template #body="slotProps">
                            <div class="flex items-center gap-2">
                                <i class="pi pi-heart-fill text-pink-500"></i>
                                <span class="font-semibold">
                                    {{ slotProps.data.likes_count }}
                                </span>
                            </div>
                        </template>
                    </Column>
                    <Column header="การจัดการ" style="width: 20%">
                        <template #body="slotProps">
                            <Button
                                asChild
                                size="small"
                                severity="secondary"
                                v-slot="buttonProps"
                            >
                                <Link
                                    :href="route('admin.destinations.edit', slotProps.data.id)"
                                    :class="buttonProps.class"
                                >
                                    <i class="pi pi-eye mr-2"></i>
                                    ดูรายละเอียด
                                </Link>
                            </Button>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </AdminLayout>
</template>
