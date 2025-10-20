<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { onMounted, ref } from "vue";
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
    destinations: {
        type: Array,
        default: () => [],
    },
});

const mapContainer = ref(null);
let map = null;

// Category color mapping
const categoryColors = {
    1: "#FF6B6B", // สีแดงอมส้ม - ท่องเที่ยวธรรมชาติ
    2: "#4ECDC4", // สีเขียวมิ้นต์ - วัฒนธรรมและประวัติศาสตร์
    3: "#FFE66D", // สีเหลือง - กิจกรรมและผจญภัย
    4: "#A8E6CF", // สีเขียวพาสเทล - สปาและเวลเนส
    5: "#FF8B94", // สีชมพู - ช้อปปิ้งและของฝาก
    6: "#95E1D3", // สีฟ้าอ่อน - อาหารและเครื่องดื่ม
    7: "#F3A683", // สีส้มอ่อน - ที่พักและโรงแรม
    8: "#786FA6", // สีม่วง - งานเทศกาลและกิจกรรม
    default: "#95A5A6", // สีเทา - อื่นๆ
};

const getCategoryColor = (categoryId) => {
    return categoryColors[categoryId] || categoryColors.default;
};

const initMap = () => {
    if (!mapContainer.value) return;

    // Initialize map centered on Thailand
    map = L.map(mapContainer.value).setView([13.736717, 100.523186], 7);

    // Add tile layer
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map);

    // Add markers for each destination
    props.destinations.forEach((destination) => {
        if (destination.latitude && destination.longitude) {
            const color = getCategoryColor(destination.category?.id);

            // Create custom icon with category color
            const customIcon = L.divIcon({
                className: "custom-marker",
                html: `
                    <div style="
                        background-color: ${color};
                        width: 30px;
                        height: 30px;
                        border-radius: 50% 50% 50% 0;
                        transform: rotate(-45deg);
                        border: 3px solid white;
                        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    ">
                        <div style="transform: rotate(45deg); color: white; font-weight: bold; font-size: 18px;">
                            📍
                        </div>
                    </div>
                `,
                iconSize: [30, 30],
                iconAnchor: [15, 30],
                popupAnchor: [0, -30],
            });

            const marker = L.marker(
                [destination.latitude, destination.longitude],
                {
                    icon: customIcon,
                }
            ).addTo(map);

            // Create popup content
            const popupContent = `
                <div class="p-2" style="min-width: 200px;">
                    ${
                        destination.cover_image
                            ? `<img src="${destination.cover_image}" alt="${destination.name}" class="w-full h-32 object-cover rounded mb-2" />`
                            : ""
                    }
                    <h3 class="font-bold text-lg mb-1">${destination.name}</h3>
                    ${
                        destination.category
                            ? `<p class="text-sm text-gray-600 mb-1">
                        <span class="inline-block w-3 h-3 rounded-full mr-1" style="background-color: ${color}"></span>
                        ${destination.category.name}
                    </p>`
                            : ""
                    }
                    ${
                        destination.address
                            ? `<p class="text-sm text-gray-500 mb-2">${destination.address}</p>`
                            : ""
                    }
                    <button
                        onclick="window.visitDestination('${destination.slug}')"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm w-full"
                    >
                        ดูรายละเอียด
                    </button>
                </div>
            `;

            marker.bindPopup(popupContent);
        }
    });

    // Fit bounds to show all markers
    if (props.destinations.length > 0) {
        const bounds = L.latLngBounds(
            props.destinations
                .filter((d) => d.latitude && d.longitude)
                .map((d) => [d.latitude, d.longitude])
        );
        map.fitBounds(bounds, { padding: [50, 50] });
    }
};

// Global function to handle destination navigation
window.visitDestination = (slug) => {
    router.visit(`/destinations/${slug}`);
};

onMounted(() => {
    initMap();
});
</script>

<template>
    <UserLayout title="แผนที่">
        <!-- Hero Section -->
        <div class="relative text-white overflow-hidden">
            <!-- Background Image -->
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="
                    background-image: url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?q=80&w=2070');
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
                        แผนที่สถานที่ท่องเที่ยว
                    </h1>
                    <p class="text-lg md:text-xl opacity-90 max-w-2xl mx-auto">
                        ค้นพบสถานที่ท่องเที่ยวทั่วประเทศไทย จำนวน
                        {{ destinations.length }} สถานที่
                    </p>
                </div>
            </div>
        </div>

        <!-- Legend Section -->
        <div
            class="bg-[var(--p-content-background)] border-b border-surface-300 dark:border-surface-700"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-lg bg-[var(--p-primary-color)]/10"
                    >
                        <i class="pi pi-map-marker text-[var(--p-primary-color)]"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold">หมวดหมู่สถานที่</h3>
                        <p class="text-xs opacity-60">
                            คลิกที่ปักหมุดบนแผนที่เพื่อดูรายละเอียด
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    <div
                        v-for="category in categories"
                        :key="category.id"
                        class="group flex items-center gap-3 px-4 py-3 rounded-lg bg-surface-50 dark:bg-surface-800 hover:bg-surface-100 dark:hover:bg-surface-700 transition-all duration-200 cursor-default border border-surface-200 dark:border-surface-600"
                    >
                        <div class="relative flex-shrink-0">
                            <div
                                class="w-3 h-3 rounded-full transition-transform duration-200 group-hover:scale-110"
                                :style="{
                                    backgroundColor: getCategoryColor(category.id),
                                    boxShadow: `0 0 0 3px ${getCategoryColor(category.id)}20`,
                                }"
                            ></div>
                            <div
                                class="absolute inset-0 w-3 h-3 rounded-full animate-ping opacity-0 group-hover:opacity-75"
                                :style="{
                                    backgroundColor: getCategoryColor(category.id),
                                }"
                            ></div>
                        </div>
                        <span class="text-sm font-medium truncate">
                            {{ category.name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div
                class="overflow-hidden border border-surface-300 dark:border-surface-700"
            >
                <div ref="mapContainer" class="w-full h-[600px]"></div>
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
