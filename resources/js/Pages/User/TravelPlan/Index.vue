<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Button } from "primevue";
import { computed, ref, onMounted, nextTick } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import L from "leaflet";
import "leaflet/dist/leaflet.css";

const props = defineProps({
    travelPlan: {
        type: Object,
        default: null,
    },
});

const showCreateForm = ref(false);
const showEditForm = ref(false);
const mapContainer = ref(null);
let map = null;

const form = ref({
    name: "",
    start_date: "",
    end_date: "",
    total_budget: "",
    notes: "",
});

const hasPlan = computed(() => props.travelPlan !== null);
const itemsByDay = computed(() => {
    if (!props.travelPlan?.items) {
        return {};
    }

    const grouped = {};
    props.travelPlan.items.forEach((item) => {
        if (!grouped[item.day_number]) {
            grouped[item.day_number] = [];
        }
        grouped[item.day_number].push(item);
    });
    return grouped;
});

const openCreateForm = () => {
    form.value = {
        name: "",
        start_date: "",
        end_date: "",
        total_budget: "",
        notes: "",
    };
    showCreateForm.value = true;
};

const openEditForm = () => {
    form.value = {
        name: props.travelPlan.name,
        start_date: props.travelPlan.start_date,
        end_date: props.travelPlan.end_date,
        total_budget: props.travelPlan.total_budget || "",
        notes: props.travelPlan.notes || "",
    };
    showEditForm.value = true;
};

const createPlan = () => {
    router.post(route("travel-plan.store"), form.value, {
        onSuccess: () => {
            showCreateForm.value = false;
        },
    });
};

const updatePlan = () => {
    router.put(
        route("travel-plan.update", props.travelPlan.id),
        form.value,
        {
            onSuccess: () => {
                showEditForm.value = false;
            },
        }
    );
};

const deletePlan = () => {
    if (
        confirm(
            "คุณต้องการลบแผนการท่องเที่ยวนี้ใช่หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้"
        )
    ) {
        router.delete(route("travel-plan.destroy", props.travelPlan.id));
    }
};

const removeItem = (itemId) => {
    if (confirm("คุณต้องการลบสถานที่นี้ออกจากแผนการท่องเที่ยวใช่หรือไม่?")) {
        axios
            .delete(route("travel-plan.items.destroy", itemId))
            .then(() => {
                router.reload();
            })
            .catch((error) => {
                alert(error.response?.data?.message || "เกิดข้อผิดพลาด");
            });
    }
};

const formatCurrency = (value) => {
    if (!value) {
        return "ไม่ระบุ";
    }
    return new Intl.NumberFormat("th-TH", {
        style: "currency",
        currency: "THB",
    }).format(value);
};

const hasDestinationsWithLocation = computed(() => {
    return props.travelPlan?.items?.some(
        (item) => item.destination.latitude && item.destination.longitude
    );
});

const initMap = () => {
    if (!mapContainer.value || !hasDestinationsWithLocation.value) return;

    // Destroy existing map if any
    if (map) {
        map.remove();
        map = null;
    }

    // Initialize map centered on Thailand
    map = L.map(mapContainer.value).setView([13.736717, 100.523186], 7);

    // Add tile layer
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map);

    const destinationsWithLocation = props.travelPlan.items.filter(
        (item) => item.destination.latitude && item.destination.longitude
    );

    // Day color mapping
    const dayColors = [
        "#FF6B6B", // Day 1 - Red
        "#4ECDC4", // Day 2 - Teal
        "#FFE66D", // Day 3 - Yellow
        "#A8E6CF", // Day 4 - Green
        "#FF8B94", // Day 5 - Pink
        "#95E1D3", // Day 6 - Light Blue
        "#F3A683", // Day 7 - Orange
        "#786FA6", // Day 8 - Purple
        "#F8B500", // Day 9 - Gold
        "#67B26F", // Day 10+ - Dark Green
    ];

    const getDayColor = (dayNumber) => {
        return dayColors[dayNumber - 1] || dayColors[9];
    };

    // Add markers for each destination
    destinationsWithLocation.forEach((item, index) => {
        const color = getDayColor(item.day_number);

        // Create custom icon with day number
        const customIcon = L.divIcon({
            className: "custom-marker",
            html: `
                <div style="
                    background-color: ${color};
                    width: 35px;
                    height: 35px;
                    border-radius: 50% 50% 50% 0;
                    transform: rotate(-45deg);
                    border: 3px solid white;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                ">
                    <div style="transform: rotate(45deg); color: white; font-weight: bold; font-size: 14px;">
                        ${item.day_number}
                    </div>
                </div>
            `,
            iconSize: [35, 35],
            iconAnchor: [17.5, 35],
            popupAnchor: [0, -35],
        });

        const marker = L.marker(
            [item.destination.latitude, item.destination.longitude],
            { icon: customIcon }
        ).addTo(map);

        // Create popup content
        const popupContent = `
            <div class="p-2" style="min-width: 220px;">
                ${
                    item.destination.cover_image
                        ? `<img src="${item.destination.cover_image}" alt="${item.destination.name}" class="w-full h-32 object-cover rounded mb-2" />`
                        : ""
                }
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-block px-2 py-1 rounded-full text-xs font-bold text-white" style="background-color: ${color}">
                        วันที่ ${item.day_number}
                    </span>
                    <span class="text-xs text-gray-500">ลำดับที่ ${item.order + 1}</span>
                </div>
                <h3 class="font-bold text-base mb-1">${item.destination.name}</h3>
                ${
                    item.destination.province
                        ? `<p class="text-sm text-gray-600 mb-1">📍 ${item.destination.province}</p>`
                        : ""
                }
                ${
                    item.estimated_cost
                        ? `<p class="text-sm text-gray-600 mb-2">💰 ${formatCurrency(
                              item.estimated_cost
                          )}</p>`
                        : ""
                }
                ${item.notes ? `<p class="text-xs text-gray-500 mb-2">${item.notes}</p>` : ""}
            </div>
        `;

        marker.bindPopup(popupContent);
    });

    // Fit bounds to show all markers
    if (destinationsWithLocation.length > 0) {
        const bounds = L.latLngBounds(
            destinationsWithLocation.map((item) => [
                item.destination.latitude,
                item.destination.longitude,
            ])
        );
        map.fitBounds(bounds, { padding: [50, 50] });
    }
};

onMounted(() => {
    if (hasPlan.value && hasDestinationsWithLocation.value) {
        nextTick(() => {
            initMap();
        });
    }
});
</script>

<template>
    <UserLayout title="แผนการท่องเที่ยว">
        <!-- Hero Section -->
        <div class="relative text-white overflow-hidden">
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="
                    background-image: url('https://images.unsplash.com/photo-1488085061387-422e29b40080?q=80&w=2070');
                "
            ></div>
            <div class="absolute inset-0 bg-black/60"></div>
            <div
                class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16"
            >
                <div class="text-center max-w-3xl mx-auto">
                    <div class="mb-4">
                        <i class="pi pi-map text-5xl opacity-90"></i>
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                        แผนการท่องเที่ยว
                    </h1>
                    <p class="text-lg md:text-xl opacity-90">
                        วางแผนการเดินทางและจัดการสถานที่ท่องเที่ยวของคุณ
                    </p>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <!-- No Plan State -->
            <div
                v-if="!hasPlan && !showCreateForm"
                class="text-center py-16"
            >
                <div
                    class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-12"
                >
                    <div class="mb-6">
                        <i
                            class="pi pi-calendar-plus text-6xl opacity-40"
                        ></i>
                    </div>
                    <h2 class="text-2xl font-bold mb-4">
                        ยังไม่มีแผนการท่องเที่ยว
                    </h2>
                    <p class="text-lg opacity-70 mb-8">
                        เริ่มสร้างแผนการท่องเที่ยวของคุณและเพิ่มสถานที่ที่ต้องการไป
                    </p>
                    <Button
                        label="สร้างแผนการท่องเที่ยว"
                        icon="pi pi-plus"
                        @click="openCreateForm"
                    />
                </div>
            </div>

            <!-- Create Form -->
            <div
                v-if="showCreateForm"
                class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-8 mb-8"
            >
                <h2 class="text-2xl font-bold mb-6">
                    สร้างแผนการท่องเที่ยวใหม่
                </h2>
                <div class="grid gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2"
                            >ชื่อแผนการท่องเที่ยว *</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                            placeholder="เช่น ทริปภูเก็ต 3 วัน 2 คืน"
                        />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2"
                                >วันที่เริ่มต้น *</label
                            >
                            <input
                                v-model="form.start_date"
                                type="date"
                                class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2"
                                >วันที่สิ้นสุด *</label
                            >
                            <input
                                v-model="form.end_date"
                                type="date"
                                class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                            />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2"
                            >งบประมาณ (บาท)</label
                        >
                        <input
                            v-model="form.total_budget"
                            type="number"
                            class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                            placeholder="0"
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2"
                            >หมายเหตุ</label
                        >
                        <textarea
                            v-model="form.notes"
                            rows="3"
                            class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                            placeholder="บันทึกเพิ่มเติม..."
                        ></textarea>
                    </div>
                    <div class="flex gap-4">
                        <Button label="สร้างแผน" @click="createPlan" />
                        <Button
                            label="ยกเลิก"
                            severity="secondary"
                            outlined
                            @click="showCreateForm = false"
                        />
                    </div>
                </div>
            </div>

            <!-- Has Plan -->
            <div v-if="hasPlan && !showEditForm">
                <!-- Plan Header -->
                <div
                    class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6 mb-8"
                >
                    <div class="flex flex-col md:flex-row justify-between gap-4">
                        <div>
                            <h2 class="text-3xl font-bold mb-2">
                                {{ travelPlan.name }}
                            </h2>
                            <div class="flex flex-wrap gap-4 text-sm opacity-70">
                                <div class="flex items-center gap-2">
                                    <i class="pi pi-calendar"></i>
                                    <span
                                        >{{ travelPlan.start_date }} -
                                        {{ travelPlan.end_date }}</span
                                    >
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="pi pi-clock"></i>
                                    <span>{{ travelPlan.total_days }} วัน</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="pi pi-map-marker"></i>
                                    <span
                                        >{{ travelPlan.items?.length || 0 }}
                                        สถานที่</span
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <Button
                                label="แก้ไข"
                                icon="pi pi-pencil"
                                severity="secondary"
                                outlined
                                @click="openEditForm"
                            />
                            <Button
                                label="ลบ"
                                icon="pi pi-trash"
                                severity="danger"
                                outlined
                                @click="deletePlan"
                            />
                        </div>
                    </div>
                </div>

                <!-- Cost Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center"
                            >
                                <i class="pi pi-wallet text-2xl text-blue-500"></i>
                            </div>
                            <div>
                                <p class="text-sm opacity-70">งบประมาณ</p>
                                <p class="text-2xl font-bold">
                                    {{ formatCurrency(travelPlan.total_budget) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center"
                            >
                                <i
                                    class="pi pi-chart-line text-2xl text-green-500"
                                ></i>
                            </div>
                            <div>
                                <p class="text-sm opacity-70">ค่าใช้จ่ายประมาณการ</p>
                                <p class="text-2xl font-bold">
                                    {{
                                        formatCurrency(
                                            travelPlan.total_estimated_cost
                                        )
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                :class="[
                                    'w-12 h-12 rounded-full flex items-center justify-center',
                                    travelPlan.total_estimated_cost >
                                    (travelPlan.total_budget || Infinity)
                                        ? 'bg-red-500/10'
                                        : 'bg-gray-500/10',
                                ]"
                            >
                                <i
                                    :class="[
                                        'pi text-2xl',
                                        travelPlan.total_estimated_cost >
                                        (travelPlan.total_budget || Infinity)
                                            ? 'pi-exclamation-triangle text-red-500'
                                            : 'pi-check-circle text-gray-500',
                                    ]"
                                ></i>
                            </div>
                            <div>
                                <p class="text-sm opacity-70">คงเหลือ</p>
                                <p class="text-2xl font-bold">
                                    {{
                                        formatCurrency(
                                            (travelPlan.total_budget || 0) -
                                                travelPlan.total_estimated_cost
                                        )
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Visualization -->
                <div
                    v-if="hasDestinationsWithLocation"
                    class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6 mb-8"
                >
                    <h3 class="text-xl font-bold mb-4">
                        <i class="pi pi-map"></i> แผนที่เส้นทางการท่องเที่ยว
                    </h3>
                    <div class="rounded-lg overflow-hidden border border-surface-300 dark:border-surface-700">
                        <div ref="mapContainer" class="w-full h-[500px]"></div>
                    </div>
                    <div class="mt-4 p-4 bg-surface-50 dark:bg-surface-900 rounded-lg">
                        <p class="text-sm opacity-70 mb-2">
                            <i class="pi pi-info-circle"></i> คำแนะนำ
                        </p>
                        <ul class="text-sm opacity-70 space-y-1 ml-4">
                            <li>• หมายเลขบนแผนที่แสดงวันที่ของการท่องเที่ยว</li>
                            <li>• คลิกที่ปักหมุดเพื่อดูรายละเอียดสถานที่</li>
                            <li>• สีของปักหมุดแยกตามวันที่</li>
                        </ul>
                    </div>
                </div>

                <!-- Timeline View -->
                <div
                    class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                >
                    <h3 class="text-xl font-bold mb-6">กำหนดการท่องเที่ยว</h3>

                    <!-- Empty State -->
                    <div
                        v-if="!travelPlan.items || travelPlan.items.length === 0"
                        class="text-center py-12"
                    >
                        <i
                            class="pi pi-map-marker text-5xl opacity-40 mb-4"
                        ></i>
                        <p class="text-lg opacity-70">
                            ยังไม่มีสถานที่ในแผนการท่องเที่ยว
                        </p>
                        <p class="text-sm opacity-50">
                            เพิ่มสถานที่จากหน้ารายการสถานที่ท่องเที่ยว
                        </p>
                    </div>

                    <!-- Days Timeline -->
                    <div v-else class="space-y-8">
                        <div
                            v-for="day in travelPlan.total_days"
                            :key="day"
                            class="relative"
                        >
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center font-bold"
                                >
                                    {{ day }}
                                </div>
                                <h4 class="text-lg font-bold">วันที่ {{ day }}</h4>
                            </div>

                            <div
                                v-if="itemsByDay[day]"
                                class="ml-6 space-y-4"
                            >
                                <div
                                    v-for="item in itemsByDay[day]"
                                    :key="item.id"
                                    class="bg-surface-50 dark:bg-surface-900 rounded-lg p-4 border border-surface-200 dark:border-surface-800"
                                >
                                    <div class="flex gap-4">
                                        <img
                                            v-if="item.destination.cover_image"
                                            :src="item.destination.cover_image"
                                            :alt="item.destination.name"
                                            class="w-24 h-24 rounded-lg object-cover"
                                        />
                                        <div
                                            v-else
                                            class="w-24 h-24 rounded-lg bg-surface-200 dark:bg-surface-800 flex items-center justify-center"
                                        >
                                            <i
                                                class="pi pi-image text-3xl opacity-30"
                                            ></i>
                                        </div>
                                        <div class="flex-1">
                                            <h5 class="font-bold text-lg mb-1">
                                                {{ item.destination.name }}
                                            </h5>
                                            <div
                                                class="flex flex-wrap gap-3 text-sm opacity-70 mb-2"
                                            >
                                                <span
                                                    v-if="item.destination.province"
                                                >
                                                    <i
                                                        class="pi pi-map-marker"
                                                    ></i>
                                                    {{ item.destination.province }}
                                                </span>
                                                <span
                                                    v-if="item.destination.category"
                                                >
                                                    <i class="pi pi-tag"></i>
                                                    {{ item.destination.category }}
                                                </span>
                                                <span v-if="item.estimated_cost">
                                                    <i class="pi pi-wallet"></i>
                                                    {{
                                                        formatCurrency(
                                                            item.estimated_cost
                                                        )
                                                    }}
                                                </span>
                                            </div>
                                            <p
                                                v-if="item.notes"
                                                class="text-sm opacity-70"
                                            >
                                                <i class="pi pi-comment"></i>
                                                {{ item.notes }}
                                            </p>
                                        </div>
                                        <Button
                                            icon="pi pi-trash"
                                            severity="danger"
                                            text
                                            rounded
                                            @click="removeItem(item.id)"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div v-else class="ml-6 text-sm opacity-50">
                                ยังไม่มีสถานที่สำหรับวันนี้
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div
                v-if="showEditForm"
                class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-8"
            >
                <h2 class="text-2xl font-bold mb-6">แก้ไขแผนการท่องเที่ยว</h2>
                <div class="grid gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2"
                            >ชื่อแผนการท่องเที่ยว *</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                        />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2"
                                >วันที่เริ่มต้น *</label
                            >
                            <input
                                v-model="form.start_date"
                                type="date"
                                class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2"
                                >วันที่สิ้นสุด *</label
                            >
                            <input
                                v-model="form.end_date"
                                type="date"
                                class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                            />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2"
                            >งบประมาณ (บาท)</label
                        >
                        <input
                            v-model="form.total_budget"
                            type="number"
                            class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2"
                            >หมายเหตุ</label
                        >
                        <textarea
                            v-model="form.notes"
                            rows="3"
                            class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                        ></textarea>
                    </div>
                    <div class="flex gap-4">
                        <Button label="บันทึก" @click="updatePlan" />
                        <Button
                            label="ยกเลิก"
                            severity="secondary"
                            outlined
                            @click="showEditForm = false"
                        />
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<style scoped>
:deep(.custom-marker) {
    background: transparent;
    border: none;
}

:deep(.leaflet-popup-content-wrapper) {
    border-radius: 8px;
    padding: 0;
}

:deep(.leaflet-popup-content) {
    margin: 0;
}
</style>
