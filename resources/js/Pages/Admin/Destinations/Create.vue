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
    categories: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    // Basic Information
    province_id: null,
    category_id: null,
    name: "",
    name_en: "",
    description: "",
    short_description: "",

    // Location & Contact
    latitude: null,
    longitude: null,
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
    price_from: null,
    price_to: null,
    pricing_note: "",
    accepts_online_booking: false,
    booking_url: "",

    // Special Features
    has_parking: false,
    has_wifi: false,
    has_restaurant: false,
    pet_friendly: false,
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

                <div class="grid grid-cols-2 gap-5">
                    <InputSection
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
                        name="category_id"
                        label="หมวดหมู่"
                        :errorMessage="form.errors.category_id"
                        required
                    >
                        <Select
                            id="category_id"
                            name="category_id"
                            v-model="form.category_id"
                            placeholder="เลือกหมวดหมู่"
                            :options="categories"
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

                <div class="grid grid-cols-2 gap-5">
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
                        <InputText
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

                <div class="grid grid-cols-2 gap-5">
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

            <!-- Pricing & Booking -->
            <div class="mb-8">
                <div
                    class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]"
                >
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-images mr-2"></i>

                        ราคาและการจอง
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        กำหนดราคาและการจองสถานที่ท่องเที่ยว
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div class="grid grid-cols-2 gap-5">
                        <InputSection
                            name="price_from"
                            label="ราคาเริ่มต้น (บาท/คืน)"
                            :errorMessage="form.errors.price_from"
                            required
                        >
                            <InputNumber
                                id="price_from"
                                name="price_from"
                                v-model="form.price_from"
                                placeholder="เช่น 500"
                                prefix="฿ "
                                :min="0"
                            />
                        </InputSection>

                        <InputSection
                            name="price_to"
                            label="ราคาสูงสุด (บาท/คืน)"
                            :errorMessage="form.errors.price_to"
                            required
                        >
                            <InputNumber
                                id="price_to"
                                name="price_to"
                                v-model="form.price_to"
                                placeholder="เช่น 5000"
                                prefix="฿ "
                                :min="0"
                            />
                        </InputSection>
                    </div>

                    <InputSection
                        name="pricing_note"
                        label="หมายเหตุราคา"
                        :errorMessage="form.errors.pricing_note"
                    >
                        <InputText
                            id="pricing_note"
                            name="pricing_note"
                            v-model="form.pricing_note"
                            placeholder="ราคาต่อคืน รวมอาหาร"
                        />
                    </InputSection>

                    <div class="grid grid-cols-2 gap-5">
                        <InputSection
                            name="accepts_online_booking"
                            label="รองรับการจองออนไลน์"
                            :errorMessage="form.errors.accepts_online_booking"
                        >
                            <ToggleSwitch
                                id="accepts_online_booking"
                                name="accepts_online_booking"
                                v-model="form.accepts_online_booking"
                            />
                        </InputSection>

                        <InputSection
                            v-if="form.accepts_online_booking"
                            name="booking_url"
                            label="ลิ้งการเข้าจอง"
                            :errorMessage="form.errors.booking_url"
                        >
                            <InputText
                                id="booking_url"
                                name="booking_url"
                                v-model="form.booking_url"
                                placeholder="https://th.trip.com/booking"
                            />
                        </InputSection>
                    </div>
                </div>
            </div>

            <!--  Special Features-->
            <div class="mb-8">
                <div
                    class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]"
                >
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-star mr-2"></i>
                        คุณสมบัติพิเศษ
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        เลือกคุณสมบัติและจุดเด่นของสถานที่ท่องเที่ยว เช่น
                        กิจกรรม สภาพแวดล้อม และเป้าหมายด้านสุขภาพ
                    </p>
                </div>

                <div class="grid grid-cols-4 gap-5">
                    <InputSection
                        name="has_parking"
                        label="มีที่จอดรถ"
                        :errorMessage="form.errors.has_parking"
                    >
                        <ToggleSwitch
                            id="has_parking"
                            name="has_parking"
                            v-model="form.has_parking"
                        />
                    </InputSection>

                    <InputSection
                        name="has_wifi"
                        label="มี Wi-Fi"
                        :errorMessage="form.errors.has_wifi"
                    >
                        <ToggleSwitch
                            id="has_wifi"
                            name="has_wifi"
                            v-model="form.has_wifi"
                        />
                    </InputSection>

                    <InputSection
                        name="has_restaurant"
                        label="มีร้านอาหาร"
                        :errorMessage="form.errors.has_restaurant"
                    >
                        <ToggleSwitch
                            id="has_restaurant"
                            name="has_restaurant"
                            v-model="form.has_restaurant"
                        />
                    </InputSection>

                    <InputSection
                        name="pet_friendly"
                        label="เป็นมิตรกับสัตว์เลี้ยง"
                        :errorMessage="form.errors.pet_friendly"
                    >
                        <ToggleSwitch
                            id="pet_friendly"
                            name="pet_friendly"
                            v-model="form.pet_friendly"
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
