<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { DataTable, Column, InputText, Tag, Button } from "primevue";
import { ref, computed } from "vue";

const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
});

const searchQuery = ref("");

const filteredUsers = computed(() => {
    let filtered = props.users;

    if (searchQuery.value) {
        filtered = filtered.filter(
            (user) =>
                user.name
                    .toLowerCase()
                    .includes(searchQuery.value.toLowerCase()) ||
                user.email
                    .toLowerCase()
                    .includes(searchQuery.value.toLowerCase())
        );
    }

    return filtered;
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

const clearFilters = () => {
    searchQuery.value = "";
};
</script>

<template>
    <AdminLayout title="จัดการผู้ใช้">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="mb-4">
                <h1 class="text-3xl font-bold mb-1">จัดการผู้ใช้</h1>
                <p class="text-sm opacity-75">
                    จัดการผู้ใช้ทั้งหมดในระบบ
                    <Tag severity="info" class="ml-2">
                        {{ users.length }} คน
                    </Tag>
                </p>
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
                            ค้นหาผู้ใช้
                        </label>
                        <InputText
                            id="search"
                            v-model="searchQuery"
                            placeholder="ค้นหาด้วยชื่อหรืออีเมล..."
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
                        <i class="pi pi-users text-blue-500"></i>
                        <span class="text-sm font-medium opacity-80">
                            <strong>{{ filteredUsers.length }}</strong> จาก
                            {{ users.length }} ผู้ใช้
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card">
            <DataTable
                :value="filteredUsers"
                paginator
                :rows="10"
                :rowsPerPageOptions="[10, 20, 50]"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                currentPageReportTemplate="แสดง {first} ถึง {last} จาก {totalRecords} รายการ"
                class="p-datatable-sm"
            >
                <Column field="id" header="#" sortable style="width: 8%">
                    <template #body="slotProps">
                        <span class="font-mono text-sm opacity-75">
                            #{{ slotProps.data.id }}
                        </span>
                    </template>
                </Column>

                <Column header="ผู้ใช้" sortable field="name" style="width: 30%">
                    <template #body="slotProps">
                        <div class="flex items-center gap-3">
                            <img
                                :src="slotProps.data.profile_photo_url"
                                :alt="slotProps.data.name"
                                class="w-10 h-10 rounded-full object-cover"
                            />
                            <div class="flex flex-col">
                                <div class="font-semibold text-base">
                                    {{ slotProps.data.name }}
                                </div>
                                <div class="text-sm opacity-80">
                                    {{ slotProps.data.email }}
                                </div>
                            </div>
                        </div>
                    </template>
                </Column>

                <Column header="สถานะอีเมล" style="width: 15%">
                    <template #body="slotProps">
                        <Tag
                            v-if="slotProps.data.email_verified_at"
                            severity="success"
                            icon="pi pi-check-circle"
                        >
                            ยืนยันแล้ว
                        </Tag>
                        <Tag v-else severity="warn" icon="pi pi-exclamation-circle">
                            ยังไม่ยืนยัน
                        </Tag>
                    </template>
                </Column>

                <Column
                    header="วันที่สมัคร"
                    sortable
                    field="created_at"
                    style="width: 20%"
                >
                    <template #body="slotProps">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-calendar text-blue-500 text-sm"></i>
                            <span class="text-sm">
                                {{ formatDate(slotProps.data.created_at) }}
                            </span>
                        </div>
                    </template>
                </Column>

                <Column
                    header="อัปเดตล่าสุด"
                    sortable
                    field="updated_at"
                    style="width: 20%"
                >
                    <template #body="slotProps">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-clock text-gray-500 text-sm"></i>
                            <span class="text-sm">
                                {{ formatDate(slotProps.data.updated_at) }}
                            </span>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </AdminLayout>
</template>
