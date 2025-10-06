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
import { ref } from "vue";

const form = useForm({
    name: "",
    name_en: "",
    description: "",
    region: "",
    latitude: "",
    longitude: "",
    image_url: "",
    is_popular: false,
});

const regions = ref([
    { label: "🏔️ เหนือ", value: "north" },
    { label: "🏙️ กลาง", value: "central" },
    { label: "🏖️ ใต้", value: "south" },
    { label: "🌾 อีสาน", value: "northeast" },
    { label: "🌅 ตะวันออก", value: "east" },
    { label: "🌄 ตะวันตก", value: "west" },
]);

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
            <div class="grid grid-cols-2 gap-4">
                <InputSection
                    name="name"
                    label="ชื่อจังหวัด"
                    :errorMessage="form.errors.name"
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
                >
                    <InputText
                        id="name_en"
                        name="name_en"
                        v-model="form.name_en"
                        placeholder="Khon Khen"
                    />
                </InputSection>

                <InputSection
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

                <InputSection
                    name="latitude"
                    label="ละติจูด"
                    :errorMessage="form.errors.latitude"
                >
                    <InputNumber
                        id="latitude"
                        name="latitude"
                        v-model="form.latitude"
                        placeholder="20.4419"
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
                        placeholder="20.4419"
                    />
                </InputSection>

                <InputSection
                    name="image_url"
                    label="รูปภาพจังหวัด"
                    :errorMessage="form.errors.image_url"
                >
                    <Textarea
                        id="image_url"
                        name="image_url"
                        v-model="form.image_url"
                        rows="5"
                        placeholder="https://example.com/image.jpg"
                    >
                    </Textarea>
                </InputSection>

                <InputSection
                    class="col-span-2"
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
            </div>

            <FormControl
                :backRoute="route('admin.provinces.index')"
                :processing="form.processing"
                @reset="form.reset()"
            />
        </form>
    </AdminLayout>
</template>
