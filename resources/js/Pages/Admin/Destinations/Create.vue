<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    InputText,
    Select,
    InputNumber,
    Textarea,
    ToggleSwitch,
} from "primevue";
import InputSection from "@/Components/Admin/InputSection.vue";
import FormControl from "@/Components/Admin/FormControl.vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
    provinces: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    // Basic Information
    province_id: "",
    name: "",
    name_en: "",
    description: "",
    short_description: "",

    // Location & Contact
    latitude: "",
    longitude: "",
    address: "",
    district: "",
    subdistrict: "",
    postal_code: "",
    phone: "",
    email: "",
    website: "",
    line_id: "",
    facebook: "",
    instagram: "",

    // Media
    cover_image: "",
    gallery_images: [],
    video_url: "",
    virtual_tour_url: "",

    // Pricing & Booking
    price_from: "",
    price_to: "",
    currency: "THB",
    pricing_note: "",
    accepts_online_booking: false,
    booking_url: "",
    min_booking_days: "",
    advance_booking_days: "",

    // Capacity & Availability
    total_rooms: "",
    max_guests: "",
    operating_hours: null,
    closed_days: [],
    opening_date: "",
    temporary_closed_from: "",
    temporary_closed_to: "",

    // Ratings & Reviews (read-only, usually not in create form)
    average_rating: 0.0,
    total_reviews: 0,
    total_bookings: 0,
    view_count: 0,
    favorite_count: 0,

    // Verification & Quality
    is_verified: false,
    verified_at: "",
    verified_by: "",
    certifications: [],
    awards: [],

    // SEO & Marketing
    meta_title: "",
    meta_description: "",
    meta_keywords: [],
    og_image: "",

    // Special Features
    has_parking: false,
    has_wifi: false,
    has_restaurant: false,
    pet_friendly: false,
    wheelchair_accessible: false,
    family_friendly: false,
    eco_friendly: false,

    // Admin & Status
    is_active: true,
    is_featured: false,
    is_recommended: false,
    sort_order: 0,
    admin_notes: "",
    published_at: "",
});

const submit = () => {
    form.post(route("admin.destinations.store"), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <AdminLayout title="เพิ่มสถานที่ท่องเที่ยว">
        <form @submit.prevent="submit">
            <!-- Basic Information Section -->
            <div class="mb-8">
                <div
                    class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]"
                >
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-info-circle mr-2"></i>
                        ข้อมูลพื้นฐาน
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        กรอกข้อมูลพื้นฐานของสถานที่ท่องเที่ยว
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <InputSection
                        class="col-span-2"
                        name="province_id"
                        label="จังหวัด"
                        :errorMessage="form.errors.province_id"
                        required
                    >
                        <Select
                            id="province_id"
                            name="province_id"
                            v-model="form.province_id"
                            placeholder="เลือกจังหวัด"
                            :options="provinces"
                            optionLabel="name"
                            optionValue="id"
                            filter
                            showClear
                        />
                    </InputSection>

                    <InputSection
                        name="name"
                        label="ชื่อสถานที่ท่องเที่ยว"
                        :errorMessage="form.errors.name"
                        required
                    >
                        <InputText
                            id="name"
                            name="name"
                            v-model="form.name"
                            placeholder="โรงแรม 5 ดาว"
                        />
                    </InputSection>

                    <InputSection
                        name="name_en"
                        label="ชื่อสถานที่ท่องเที่ยว (อังกฤษ)"
                        :errorMessage="form.errors.name_en"
                        required
                    >
                        <InputText
                            id="name_en"
                            name="name_en"
                            v-model="form.name_en"
                            placeholder="5 Star Hotel"
                        />
                    </InputSection>

                    <InputSection
                        class="col-span-2"
                        name="short_description"
                        label="คำอธิบายสั้น"
                        :errorMessage="form.errors.short_description"
                        required
                    >
                        <Textarea
                            id="short_description"
                            name="short_description"
                            v-model="form.short_description"
                            rows="3"
                            placeholder="คำอธิบายสั้นๆ สำหรับแสดงในรายการ (ไม่เกิน 200 ตัวอักษร)"
                        />
                    </InputSection>

                    <InputSection
                        class="col-span-2"
                        name="description"
                        label="รายละเอียดเต็ม"
                        :errorMessage="form.errors.description"
                    >
                        <Textarea
                            id="description"
                            name="description"
                            v-model="form.description"
                            rows="8"
                            placeholder="รายละเอียดเต็มของสถานที่ท่องเที่ยว เช่น จุดเด่น กิจกรรม สิ่งอำนวยความสะดวก..."
                        />
                    </InputSection>
                </div>
            </div>

            <!-- Location & Contact Section -->
            <div class="mb-8">
                <div
                    class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]"
                >
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-info-circle mr-2"></i>

                        ข้อมูลติดต่อ
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        กรอกข้อมูลติดต่อสำหรับสถานที่ท่องเที่ยว
                    </p>
                </div>
            </div>

            <FormControl
                :backRoute="route('admin.destinations.index')"
                :processing="form.processing"
                @reset="form.reset()"
            />
        </form>
    </AdminLayout>
</template>
