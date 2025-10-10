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
    regions: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: "",
    name_en: "",
    description: "",
    region: "",
    latitude: "",
    longitude: "",
    image_url: "",
    is_popular: false,
    sort_order: 0,
});

const submit = () => {
    form.post(route("admin.provinces.store"), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <AdminLayout title="เพิ่มจังหวัด">
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
                        กรอกข้อมูลพื้นฐานของจังหวัด
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <InputSection
                        name="name"
                        label="ชื่อจังหวัด"
                        :errorMessage="form.errors.name"
                        required
                    >
                        <InputText
                            id="name"
                            name="name"
                            v-model="form.name"
                            placeholder="ขอนแก่น"
                        />
                    </InputSection>

                    <InputSection
                        name="name_en"
                        label="ชื่อจังหวัด (อังกฤษ)"
                        :errorMessage="form.errors.name_en"
                        required
                    >
                        <InputText
                            id="name_en"
                            name="name_en"
                            v-model="form.name_en"
                            placeholder="Khon Kaen"
                        />
                    </InputSection>

                    <InputSection
                        class="col-span-2"
                        name="description"
                        label="รายละเอียดจังหวัด"
                        :errorMessage="form.errors.description"
                    >
                        <Textarea
                            id="description"
                            name="description"
                            v-model="form.description"
                            rows="5"
                            placeholder="จังหวัดขอนแก่น เป็นจังหวัดที่ตั้งอยู่ในภาคตะวันออกเฉียงเหนือของประเทศไทย..."
                        >
                        </Textarea>
                    </InputSection>

                    <InputSection
                        class="col-span-2"
                        name="region"
                        label="ภูมิภาค"
                        :errorMessage="form.errors.region"
                        required
                    >
                        <Select
                            id="region"
                            name="region"
                            v-model="form.region"
                            placeholder="เลือกภูมิภาค"
                            :options="regions"
                            optionLabel="label"
                            optionValue="value"
                        />
                    </InputSection>
                </div>
            </div>

            <!-- Location Section -->
            <div class="mb-8">
                <div
                    class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]"
                >
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-map-marker mr-2"></i>
                        ตำแหน่งที่ตั้ง
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        ระบุพิกัดทางภูมิศาสตร์ของจังหวัด
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <InputSection
                        name="latitude"
                        label="ละติจูด"
                        :errorMessage="form.errors.latitude"
                    >
                        <InputNumber
                            id="latitude"
                            name="latitude"
                            v-model="form.latitude"
                            placeholder="16.4419"
                            :minFractionDigits="4"
                            :maxFractionDigits="6"
                        />
                    </InputSection>

                    <InputSection
                        name="longitude"
                        label="ลองจิจูด"
                        :errorMessage="form.errors.longitude"
                    >
                        <InputNumber
                            id="longitude"
                            name="longitude"
                            v-model="form.longitude"
                            placeholder="102.8359"
                            :minFractionDigits="4"
                            :maxFractionDigits="6"
                        />
                    </InputSection>
                </div>
            </div>

            <!-- Media Section -->
            <div class="mb-8">
                <div
                    class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]"
                >
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-image mr-2"></i>
                        รูปภาพ
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        เพิ่มรูปภาพประกอบของจังหวัด
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <InputSection
                        name="image_url"
                        label="URL รูปภาพจังหวัด"
                        :errorMessage="form.errors.image_url"
                        required
                    >
                        <Textarea
                            id="image_url"
                            name="image_url"
                            v-model="form.image_url"
                            rows="3"
                            placeholder="https://example.com/image.jpg"
                        >
                        </Textarea>
                    </InputSection>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="mb-8">
                <div
                    class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]"
                >
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-cog mr-2"></i>
                        การตั้งค่า
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        ตั้งค่าการแสดงผลและลำดับความสำคัญ
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <InputSection
                        name="is_popular"
                        label="ยอดนิยม"
                        :errorMessage="form.errors.is_popular"
                    >
                        <ToggleSwitch
                            id="is_popular"
                            name="is_popular"
                            v-model="form.is_popular"
                        />
                    </InputSection>

                    <InputSection
                        name="sort_order"
                        label="ลำดับการแสดง"
                        :errorMessage="form.errors.sort_order"
                    >
                        <InputNumber
                            id="sort_order"
                            name="sort_order"
                            v-model="form.sort_order"
                            placeholder="1"
                        />
                    </InputSection>
                </div>
            </div>

            <FormControl
                :backRoute="route('admin.provinces.index')"
                :processing="form.processing"
                @reset="form.reset()"
            />
        </form>
    </AdminLayout>
</template>
