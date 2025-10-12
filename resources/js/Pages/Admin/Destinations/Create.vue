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
import { computed } from "vue";

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

const galleryImagesText = computed({
    get() {
        return Array.isArray(form.gallery_images)
            ? form.gallery_images.join(",\n")
            : "";
    },
    set(value) {
        form.gallery_images = value
            .split(",")
            .map((url) => url.trim())
            .filter((url) => url.length > 0);
    },
});

const removeImage = (index) => {
    form.gallery_images.splice(index, 1);
};

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

                <div class="grid grid-cols-2 gap-4">
                    <InputSection
                        name="latitude"
                        label="ละติจูล (Latitude)"
                        :errorMessage="form.errors.latitude"
                        required
                    >
                        <InputNumber
                            id="latitude"
                            name="latitude"
                            v-model="form.latitude"
                            placeholder="ละติจูล"
                            precision="6"
                            decimalPlaces="6"
                        />
                    </InputSection>

                    <InputSection
                        name="longitude"
                        label="ลองติจูล (Longitude)"
                        :errorMessage="form.errors.longitude"
                        required
                    >
                        <InputNumber
                            id="longitude"
                            name="longitude"
                            v-model="form.longitude"
                            placeholder="ลองติจูล"
                            precision="6"
                            decimalPlaces="6"
                        />
                    </InputSection>

                    <InputSection
                        name="address"
                        label="ที่อยู่"
                        :errorMessage="form.errors.address"
                    >
                        <InputText
                            id="address"
                            name="address"
                            v-model="form.address"
                            placeholder="ที่อยู่ในร้าน..."
                        />
                    </InputSection>

                    <InputSection
                        name="district"
                        label="เขต/อำเภอ"
                        :errorMessage="form.errors.district"
                    >
                        <InputText
                            id="district"
                            name="district"
                            v-model="form.district"
                            placeholder="บางบอน"
                        />
                    </InputSection>

                    <InputSection
                        name="subdistrict"
                        label="แขวง/ตำบล"
                        :errorMessage="form.errors.subdistrict"
                    >
                        <InputText
                            id="subdistrict"
                            name="subdistrict"
                            v-model="form.subdistrict"
                            placeholder="บางพลัด"
                        />
                    </InputSection>

                    <InputSection
                        name="postal_code"
                        label="รหัสไปรษณีย์"
                        :errorMessage="form.errors.postal_code"
                    >
                        <InputNumber
                            id="postal_code"
                            name="postal_code"
                            v-model="form.postal_code"
                            placeholder="10100"
                        />
                    </InputSection>

                    <InputSection
                        name="phone"
                        label="เบอร์โทรศัพท์"
                        :errorMessage="form.errors.phone"
                    >
                        <InputText
                            id="phone"
                            name="phone"
                            v-model="form.phone"
                            placeholder="111222333"
                        />
                    </InputSection>

                    <InputSection
                        name="email"
                        label="อีเมล"
                        :errorMessage="form.errors.email"
                    >
                        <InputText
                            id="email"
                            name="email"
                            v-model="form.email"
                            placeholder="travel@example.com"
                        />
                    </InputSection>

                    <InputSection
                        name="website"
                        label="เว็บไซต์"
                        :errorMessage="form.errors.website"
                    >
                        <InputText
                            id="website"
                            name="website"
                            v-model="form.website"
                            placeholder="https://th.trip.com"
                        />
                    </InputSection>

                    <InputSection
                        name="line_id"
                        label="ไลท์ไอดี"
                        :errorMessage="form.errors.line_id"
                    >
                        <InputText
                            id="line_id"
                            name="line_id"
                            v-model="form.line_id"
                            placeholder="@travel123"
                        />
                    </InputSection>

                    <InputSection
                        name="facebook"
                        label="facebook"
                        :errorMessage="form.errors.facebook"
                    >
                        <template #image>
                            <img
                                class="size-5"
                                src="/images/facebook.png"
                                alt="facebook"
                            />
                        </template>
                        <InputText
                            id="facebook"
                            name="facebook"
                            v-model="form.facebook"
                            placeholder="facebook.com/spa_thailand"
                        />
                    </InputSection>

                    <InputSection
                        name="instagram"
                        label="instagram"
                        :errorMessage="form.errors.instagram"
                    >
                        <template #image>
                            <img
                                class="size-5"
                                src="/images/instagram.png"
                                alt="instagram"
                            />
                        </template>
                        <InputText
                            id="instagram"
                            name="instagram"
                            v-model="form.instagram"
                            placeholder="instagram.com/spa_thailand"
                        />
                    </InputSection>
                </div>
            </div>

            <!-- Media -->
            <div class="mb-8">
                <div
                    class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]"
                >
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-images mr-2"></i>

                        รูปภาพและวีดีโอ
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        อัพโหลดรูปภาพและวีดีโอสำหรับสถานที่ท่องเที่ยว
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <InputSection
                        name="cover_image"
                        label="รูปหลัก"
                        :errorMessage="form.errors.cover_image"
                        required
                    >
                        <InputText
                            id="cover_image"
                            name="cover_image"
                            v-model="form.cover_image"
                            placeholder="unsplash.com/travel_photo_1"
                        />

                        <div
                            v-if="form.cover_image"
                            class="aspect-square overflow-hidden max-w-[200px] max-h-[200px]"
                        >
                            <img
                                :src="form.cover_image"
                                alt="แสดงรูปหลัก"
                                class="w-full h-full object-cover rounded-sm"
                                @error="
                                    $event.target.src =
                                        'https://placehold.co/200x200?text=Invalid+URL'
                                "
                            />
                        </div>
                    </InputSection>

                    <InputSection
                        class="col-span-2"
                        name="gallery_images"
                        label="รูปร่วมแกลเลอรี่"
                        :errorMessage="form.errors.gallery_images"
                        required
                    >
                        <Textarea
                            id="gallery_images"
                            name="gallery_images"
                            v-model="galleryImagesText"
                            rows="5"
                            placeholder="unsplash.com/travel_photo_1,&#10;unsplash.com/travel_photo_2,&#10;unsplash.com/travel_photo_3"
                        />

                        <small class="block mt-1 text-sm opacity-75">
                            <i class="pi pi-info-circle mr-1"></i>
                            แยก URL แต่ละรูปด้วยเครื่องหมาย comma (,)
                            หรือขึ้นบรรทัดใหม่
                        </small>

                        <div v-if="form.gallery_images.length > 0">
                            <Tag severity="info">
                                <i class="pi pi-images mr-1"></i>
                                {{ form.gallery_images.length }} รูปภาพ
                            </Tag>
                        </div>

                        <div
                            class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3"
                        >
                            <div
                                v-for="(image, index) in form.gallery_images"
                                :key="index"
                                class="relative group cursor-pointer"
                                @click="removeImage(index)"
                                title="คลิกเพื่อลบรูปภาพ"
                            >
                                <div class="aspect-square overflow-hidden">
                                    <img
                                        :src="image"
                                        :alt="`Gallery image ${index + 1}`"
                                        class="w-full h-full object-cover rounded-sm group-hover:opacity-75 transition-opacity"
                                        @error="
                                            $event.target.src =
                                                'https://placehold.co/200x200?text=Invalid+URL'
                                        "
                                    />
                                </div>

                                <!-- Image Number Badge -->
                                <div
                                    class="absolute top-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded-full font-medium"
                                >
                                    #{{ index + 1 }}
                                </div>

                                <!-- Delete Icon (shows on hover) -->
                                <div
                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                                >
                                    <div
                                        class="bg-red-500 text-white rounded-full p-3 shadow-lg"
                                    >
                                        <i class="pi pi-trash text-xl"></i>
                                    </div>
                                </div>

                                <!-- URL Preview on Hover -->
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-black/80 text-white text-xs p-2 opacity-0 group-hover:opacity-100 transition-opacity truncate"
                                >
                                    {{ image }}
                                </div>
                            </div>
                        </div>
                    </InputSection>

                    <InputSection
                        name="video_url"
                        label="วีดีโอหลัก"
                        :errorMessage="form.errors.video_url"
                    >
                        <InputText
                            id="video_url"
                            name="video_url"
                            v-model="form.video_url"
                            placeholder="unsplash.com/travel_video"
                        />
                    </InputSection>

                    <InputSection
                        name="virtual_tour_url"
                        label="วีดีโอทัวร์"
                        :errorMessage="form.errors.virtual_tour_url"
                    >
                        <InputText
                            id="virtual_tour_url"
                            name="virtual_tour_url"
                            v-model="form.virtual_tour_url"
                            placeholder="unsplash.com/travel_video_tour"
                        />
                    </InputSection>
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
