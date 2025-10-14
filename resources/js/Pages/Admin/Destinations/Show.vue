<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Button, Tag, Card } from "primevue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    destination: {
        type: Object,
        required: true,
    },
    regions: {
        type: Object,
        required: true,
    },
});

const getYesNoLabel = (value) => {
    return value ? "รองรับ" : "ไม่รองรับ";
};

const getYesNoSeverity = (value) => {
    return value ? "success" : "danger";
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
</script>

<template>
    <AdminLayout :title="'แสดงข้อมูล ' + props.destination.name">
        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-6">
            <Button label="กลับ" icon="pi pi-arrow-left" severity="secondary"
                @click="router.get(route('admin.destinations.index'))" />
            <div class="flex gap-2">
                <Button label="แก้ไข" icon="pi pi-pencil" @click="
                    router.get(
                        route('admin.destinations.edit', destination.id)
                    )
                    " />
            </div>
        </div>

        <!-- Cover Image -->
        <div class="mb-8">
            <div class="relative w-full h-[400px] overflow-hidden">
                <img :src="destination.cover_image" :alt="destination.name" class="w-full h-full object-cover" @error="
                    $event.target.src =
                    'https://placehold.co/1200x400?text=No+Image'
                    " />
                <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                <div class="absolute bottom-6 left-6 text-white">
                    <h1 class="text-4xl font-bold mb-2">
                        {{ destination.name }}
                    </h1>
                    <p class="text-xl opacity-90">{{ destination.name_en }}</p>
                </div>
            </div>
        </div>

        <!-- Basic Information -->
        <Card class="mb-6">
            <template #title>
                <div class="flex items-center gap-2">
                    <i class="pi pi-info-circle text-2xl"></i>
                    <span>ข้อมูลพื้นฐาน</span>
                </div>
            </template>
            <template #content>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            จังหวัด
                        </label>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-map-marker text-primary"></i>
                            <span class="text-lg">
                                {{ destination.province?.name || "-" }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            ภูมิภาค
                        </label>
                        <Tag :value="regions[destination.province?.region] || '-'
                            " :severity="getRegionColor(destination.province?.region)
                                " />
                    </div>

                    <div class="col-span-2">
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            คำอธิบายสั้น
                        </label>
                        <p class="text-base leading-relaxed">
                            {{ destination.short_description || "-" }}
                        </p>
                    </div>

                    <div class="col-span-2">
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            รายละเอียดเต็ม
                        </label>
                        <p class="text-base leading-relaxed whitespace-pre-line">
                            {{ destination.description || "-" }}
                        </p>
                    </div>
                </div>
            </template>
        </Card>

        <Card v-if="destination.preference" class="mb-6">
            <template #title>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="pi pi-heart text-2xl"></i>
                        <span>ความชอบของสถานที่</span>
                    </div>
                    <Button label="แก้ไข" icon="pi pi-pencil" size="small" severity="info"
                        @click="router.get(route('admin.destinations.preferences.edit', destination.id))" />
                </div>
            </template>

            <template #content>
                <div class="space-y-8">
                    <!-- ข้อมูลความชอบของสถานที่ท่องเที่ยว -->
                    <div>
                        <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                            <i class="pi pi-heart-fill text-pink-500"></i>
                            เป้าหมายด้านสุขภาพ
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <Tag v-for="value in destination.preference.wellness_goals" :key="value.id"
                                :value="value.icon ? `${value.icon} ${value.name}` : value.name" severity="info"
                                class="text-base px-4 py-2" />
                        </div>
                    </div>

                    <!-- กิจกรรมสุขภาพ -->
                    <div>
                        <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                            <i class="pi pi-bolt text-orange-500"></i>
                            กิจกรรมสุขภาพ
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <Tag v-for="value in destination.preference.activities" :key="value.id"
                                :value="value.icon ? `${value.icon} ${value.name}` : value.name" severity="success"
                                class="text-base px-4 py-2" />
                        </div>
                    </div>

                    <!-- สภาพแวดล้อมและบรรยากาศ -->
                    <div>
                        <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                            <i class="pi pi-sun text-yellow-500"></i>
                            สภาพแวดล้อมและบรรยากาศ
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <Tag v-for="value in destination.preference.environments" :key="value.id"
                                :value="value.icon ? `${value.icon} ${value.name}` : value.name" severity="warn"
                                class="text-base px-4 py-2" />
                        </div>
                    </div>

                    <!-- ระยะเวลาและความเข้มข้นของโปรแกรม -->
                    <div>
                        <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                            <i class="pi pi-clock text-blue-500"></i>
                            ระยะเวลาและความเข้มข้นของโปรแกรม
                        </h3>
                        <Tag :value="destination.preference.duration_intensity.icon
                            ? `${destination.preference.duration_intensity.icon} ${destination.preference.duration_intensity.name}`
                            : destination.preference.duration_intensity.name" severity="contrast"
                            class="text-base px-4 py-2" />
                    </div>

                    <!-- งบประมาณและที่พัก -->
                    <div>
                        <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                            <i class="pi pi-wallet text-green-500"></i>
                            งบประมาณและที่พัก
                        </h3>
                        <Tag :value="destination.preference.budget_accommodation.icon
                            ? `${destination.preference.budget_accommodation.icon} ${destination.preference.budget_accommodation.name}`
                            : destination.preference.budget_accommodation.name" severity="success"
                            class="text-base px-4 py-2" />
                    </div>

                    <!-- Keywords -->
                    <div v-if="destination.preference.keywords && destination.preference.keywords.length > 0">
                        <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                            <i class="pi pi-tags text-purple-500"></i>
                            คำค้นหา (Keywords)
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <Tag v-for="(keyword, index) in destination.preference.keywords" :key="index"
                                :value="keyword" severity="secondary" class="text-sm px-3 py-1" />
                        </div>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Location & Contact -->
        <Card class="mb-6">
            <template #title>
                <div class="flex items-center gap-2">
                    <i class="pi pi-map text-2xl"></i>
                    <span>ที่อยู่และติดต่อ</span>
                </div>
            </template>
            <template #content>
                <div class="grid grid-cols-2 gap-6">
                    <!-- Address -->
                    <div class="col-span-2">
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            <i class="pi pi-home mr-1"></i>
                            ที่อยู่
                        </label>
                        <p class="text-base">
                            {{ destination.address || "-" }}
                            {{
                                destination.subdistrict
                                    ? `แขวง/ตำบล${destination.subdistrict}`
                                    : ""
                            }}
                            {{
                                destination.district
                                    ? `เขต/อำเภอ${destination.district}`
                                    : ""
                            }}
                            {{ destination.province?.name || "" }}
                            {{ destination.postal_code || "" }}
                        </p>
                    </div>

                    <!-- Coordinates -->
                    <div>
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            <i class="pi pi-compass mr-1"></i>
                            พิกัด
                        </label>
                        <p class="text-base">
                            {{ destination.latitude }},
                            {{ destination.longitude }}
                        </p>
                        <a :href="`https://www.google.com/maps?q=${destination.latitude},${destination.longitude}`"
                            target="_blank" class="text-primary text-sm hover:underline">
                            <i class="pi pi-external-link mr-1"></i>
                            ดูบน Google Maps
                        </a>
                    </div>

                    <!-- Contact -->
                    <div>
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            <i class="pi pi-phone mr-1"></i>
                            ติดต่อ
                        </label>
                        <div class="space-y-2">
                            <p v-if="destination.phone" class="text-base">
                                <i class="pi pi-phone mr-2 text-primary"></i>
                                {{ destination.phone }}
                            </p>
                            <p v-if="destination.email" class="text-base">
                                <i class="pi pi-envelope mr-2 text-primary"></i>
                                {{ destination.email }}
                            </p>
                            <p v-if="destination.line_id" class="text-base">
                                <i class="pi pi-comment mr-2 text-primary"></i>
                                {{ destination.line_id }}
                            </p>
                        </div>
                    </div>

                    <!-- Website & Social -->
                    <div class="col-span-2">
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            <i class="pi pi-globe mr-1"></i>
                            เว็บไซต์และโซเชียลมีเดีย
                        </label>
                        <div class="flex flex-wrap gap-3">
                            <a v-if="destination.website" :href="destination.website" target="_blank"
                                class="text-primary hover:underline">
                                <Button icon="pi pi-globe" label="Website" severity="secondary" outlined />
                            </a>
                            <a v-if="destination.facebook" :href="destination.facebook" target="_blank">
                                <Button severity="secondary" outlined>
                                    <img class="size-4 mr-2" src="/images/facebook.png" alt="facebook" />
                                    Facebook
                                </Button>
                            </a>
                            <a v-if="destination.instagram" :href="destination.instagram" target="_blank">
                                <Button severity="secondary" outlined>
                                    <img class="size-4 mr-2" src="/images/instagram.png" alt="instagram" />
                                    Instagram
                                </Button>
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Gallery -->
        <Card class="mb-6" v-if="destination.gallery_images_array?.length > 0">
            <template #title>
                <div class="flex items-center gap-2">
                    <i class="pi pi-images text-2xl"></i>
                    <span>แกลเลอรี่รูปภาพ</span>
                    <Tag :value="`${destination.gallery_images_array.length} รูป`" severity="info" />
                </div>
            </template>
            <template #content>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <div v-for="(image, index) in destination.gallery_images_array" :key="index"
                        class="relative group cursor-pointer">
                        <div class="aspect-square overflow-hidden rounded-lg">
                            <img :src="image" :alt="`Gallery ${index + 1}`"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                @error="
                                    $event.target.src =
                                    'https://placehold.co/300x300?text=No+Image'
                                    " />
                        </div>
                        <div class="absolute top-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded-full">
                            #{{ index + 1 }}
                        </div>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Media -->
        <Card class="mb-6" v-if="destination.video_url || destination.virtual_tour_url">
            <template #title>
                <div class="flex items-center gap-2">
                    <i class="pi pi-video text-2xl"></i>
                    <span>วีดีโอและทัวร์เสมือนจริง</span>
                </div>
            </template>
            <template #content>
                <div class="grid grid-cols-2 gap-6">
                    <div v-if="destination.video_url">
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            <i class="pi pi-youtube mr-1"></i>
                            วีดีโอหลัก
                        </label>
                        <a :href="destination.video_url" target="_blank" class="text-primary hover:underline">
                            {{ destination.video_url }}
                        </a>
                    </div>

                    <div v-if="destination.virtual_tour_url">
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            <i class="pi pi-eye mr-1"></i>
                            ทัวร์เสมือนจริง 360°
                        </label>
                        <a :href="destination.virtual_tour_url" target="_blank" class="text-primary hover:underline">
                            {{ destination.virtual_tour_url }}
                        </a>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Pricing & Booking -->
        <Card class="mb-6">
            <template #title>
                <div class="flex items-center gap-2">
                    <i class="pi pi-dollar text-2xl"></i>
                    <span>ราคาและการจอง</span>
                </div>
            </template>
            <template #content>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            ช่วงราคา
                        </label>
                        <div class="flex items-center gap-2">
                            <Tag v-if="destination.price_from" :value="`${destination.price_from.toLocaleString()} ${destination.currency
                                }`" severity="success" />
                            <span v-if="
                                destination.price_from &&
                                destination.price_to
                            ">-</span>
                            <Tag v-if="destination.price_to" :value="`${destination.price_to.toLocaleString()} ${destination.currency
                                }`" severity="success" />
                            <span v-if="
                                !destination.price_from &&
                                !destination.price_to
                            ">-</span>
                        </div>
                        <p v-if="destination.pricing_note" class="text-sm opacity-75 mt-2">
                            {{ destination.pricing_note }}
                        </p>
                    </div>

                    <div>
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            การจองออนไลน์
                        </label>
                        <Tag :value="destination.accepts_online_booking
                            ? 'รับจองออนไลน์'
                            : 'ไม่รับจองออนไลน์'
                            " :severity="destination.accepts_online_booking
                                ? 'success'
                                : 'secondary'
                                " />
                        <div v-if="destination.booking_url" class="mt-2">
                            <a :href="destination.booking_url" target="_blank"
                                class="text-primary hover:underline text-sm">
                                <i class="pi pi-external-link mr-1"></i>
                                ลิงก์จอง
                            </a>
                        </div>
                    </div>

                    <div v-if="
                        destination.min_booking_days ||
                        destination.advance_booking_days
                    ">
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            เงื่อนไขการจอง
                        </label>
                        <div class="space-y-1">
                            <p v-if="destination.min_booking_days" class="text-sm">
                                <i class="pi pi-calendar mr-1 text-primary"></i>
                                จองขั้นต่ำ
                                {{ destination.min_booking_days }} วัน
                            </p>
                            <p v-if="destination.advance_booking_days" class="text-sm">
                                <i class="pi pi-clock mr-1 text-primary"></i>
                                จองล่วงหน้า
                                {{ destination.advance_booking_days }} วัน
                            </p>
                        </div>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Ratings & Statistics -->
        <Card class="mb-6">
            <template #title>
                <div class="flex items-center gap-2">
                    <i class="pi pi-star text-2xl"></i>
                    <span>คะแนนและสถิติ</span>
                </div>
            </template>
            <template #content>
                <div class="grid grid-cols-4 gap-6">
                    <div>
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            คะแนนเฉลี่ย
                        </label>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-star-fill text-yellow-500 text-xl"></i>
                            <span class="text-2xl font-bold">
                                {{ destination.average_rating || 0 }}
                            </span>
                            <span class="text-sm opacity-75">/5.00</span>
                        </div>
                    </div>

                    <div>
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            จำนวนรีวิว
                        </label>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-comment text-primary text-xl"></i>
                            <span class="text-2xl font-bold">
                                {{ destination.total_reviews.toLocaleString() }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            จำนวนการจอง
                        </label>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-calendar-plus text-primary text-xl"></i>
                            <span class="text-2xl font-bold">
                                {{
                                    destination.total_bookings.toLocaleString()
                                }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            จำนวนการเข้าชม
                        </label>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-eye text-primary text-xl"></i>
                            <span class="text-2xl font-bold">
                                {{ destination.view_count.toLocaleString() }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="font-semibold text-sm opacity-75 block mb-2">
                            บันทึกเป็นที่ชอบ
                        </label>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-heart-fill text-red-500 text-xl"></i>
                            <span class="text-2xl font-bold">
                                {{
                                    destination.favorite_count.toLocaleString()
                                }}
                            </span>
                        </div>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Special Features -->
        <Card class="mb-6">
            <template #title>
                <div class="flex items-center gap-2">
                    <i class="pi pi-sparkles text-2xl"></i>
                    <span>สิ่งอำนวยความสะดวก</span>
                </div>
            </template>
            <template #content>
                <div class="grid grid-cols-4 gap-4">
                    <div class="flex items-center gap-3">
                        <i class="pi pi-car text-2xl text-primary"></i>
                        <div>
                            <p class="font-semibold text-sm">ที่จอดรถ</p>
                            <Tag :value="getYesNoLabel(destination.has_parking)" :severity="getYesNoSeverity(destination.has_parking)
                                " size="small" />
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <i class="pi pi-wifi text-2xl text-primary"></i>
                        <div>
                            <p class="font-semibold text-sm">WiFi</p>
                            <Tag :value="getYesNoLabel(destination.has_wifi)" :severity="getYesNoSeverity(destination.has_wifi)
                                " size="small" />
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <i class="pi pi-shopping-bag text-2xl text-primary"></i>
                        <div>
                            <p class="font-semibold text-sm">ร้านอาหาร</p>
                            <Tag :value="getYesNoLabel(destination.has_restaurant)
                                " :severity="getYesNoSeverity(destination.has_restaurant)
                                    " size="small" />
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <i class="pi pi-heart text-2xl text-primary"></i>
                        <div>
                            <p class="font-semibold text-sm">รับสัตว์เลี้ยง</p>
                            <Tag :value="getYesNoLabel(destination.pet_friendly)" :severity="getYesNoSeverity(destination.pet_friendly)
                                " size="small" />
                        </div>
                    </div>
                </div>
            </template>
        </Card>
    </AdminLayout>
</template>
