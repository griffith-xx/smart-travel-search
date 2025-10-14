<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    InputText,
    InputNumber,
    Textarea,
    ToggleSwitch,
} from "primevue";
import InputSection from "@/Components/Admin/InputSection.vue";
import FormControl from "@/Components/Admin/FormControl.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    name_en: "",
    description: "",
    image_url: "",
    is_popular: false,
    sort_order: 0,
});

const submit = () => {
    form.post(route("admin.categories.store"), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <AdminLayout title="เพิ่มหมวดหมู่">
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
                        กรอกข้อมูลพื้นฐานของหมวดหมู่
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <InputSection
                        name="name"
                        label="ชื่อหมวดหมู่"
                        :errorMessage="form.errors.name"
                        required
                    >
                        <InputText
                            id="name"
                            name="name"
                            v-model="form.name"
                            placeholder="ออนเซ็นและน้ำแร่"
                        />
                    </InputSection>

                    <InputSection
                        name="name_en"
                        label="ชื่อหมวดหมู่ (อังกฤษ)"
                        :errorMessage="form.errors.name_en"
                        required
                    >
                        <InputText
                            id="name_en"
                            name="name_en"
                            v-model="form.name_en"
                            placeholder="Hot Spring & Mineral Water"
                        />
                    </InputSection>

                    <InputSection
                        class="col-span-2"
                        name="description"
                        label="รายละเอียดหมวดหมู่"
                        :errorMessage="form.errors.description"
                    >
                        <Textarea
                            id="description"
                            name="description"
                            v-model="form.description"
                            rows="5"
                            placeholder="แหล่งน้ำแร่ธรรมชาติ ออนเซ็น และบ่อน้ำร้อนเพื่อการบำบัด..."
                        >
                        </Textarea>
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
                        เพิ่มรูปภาพประกอบของหมวดหมู่
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <InputSection
                        name="image_url"
                        label="URL รูปภาพหมวดหมู่"
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
                :backRoute="route('admin.categories.index')"
                :processing="form.processing"
                @reset="form.reset()"
            />
        </form>
    </AdminLayout>
</template>
