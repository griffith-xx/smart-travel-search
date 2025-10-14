<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Checkbox, RadioButton, Textarea } from "primevue";
import InputSection from "@/Components/Admin/InputSection.vue";
import FormControl from "@/Components/Admin/FormControl.vue";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    destination: {
        type: Object,
        required: true,
    },
    featureWellnessGoals: {
        type: Object,
        required: true,
    },
    featureActivities: {
        type: Object,
        required: true,
    },
    featureEnvironments: {
        type: Object,
        required: true,
    },
    featureDurationIntensities: {
        type: Object,
        required: true,
    },
    featureBudgetAccommodations: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    wellnessGoals: props.destination.preference.wellness_goals || [],
    activities: props.destination.preference.activities || [],
    environments: props.destination.preference.environments || [],
    durationIntensity:
        props.destination.preference.duration_intensity_id || null,
    budgetAccommodation:
        props.destination.preference.budget_accommodation_id || null,
    keywords: props.destination.preference.keywords || [
        "ภูเขา",
        "ท่องเที่ยว",
        "ที่พัก",
    ],
});

const submit = () => {
    form.patch(
        route("admin.destinations.preferences.update", props.destination.id)
    );
};

const handleKeywords = computed({
    get() {
        return Array.isArray(form.keywords) ? form.keywords.join(",") : "";
    },
    set(value) {
        form.keywords = value
            .split(",")
            .map((keyword) => keyword.trim())
            .filter((keyword) => keyword.length > 0);
    },
});
</script>

<template>
    <AdminLayout :title="'จัดการความชอบ ' + props.destination.name">
        <form @submit.prevent="submit">
            <div class="mb-8">
                <div class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]">
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-info-circle mr-2"></i>
                        ข้อมูลความชอบของสถานที่ท่องเที่ยว
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        กำหนดค่าความชอบต่างๆ สำหรับสถานที่ท่องเที่ยวนี้
                        เพื่อช่วยให้ระบบแนะนำสถานที่ท่องเที่ยวได้ตรงกับความต้องการของผู้ใช้งานมากขึ้น
                    </p>
                </div>
                <div class="grid grid-cols-2">
                    <InputSection class="col-span-2" name="wellnessGoals" :errorMessage="form.errors.wellnessGoals"
                        required noLabel>
                        <div v-for="feature in featureWellnessGoals" :key="feature.id" class="flex items-center gap-2">
                            <Checkbox v-model="form.wellnessGoals" :inputId="feature.slug" :name="feature.name"
                                :value="feature.id" />
                            <label :for="feature.slug">
                                <span class="opacity-80">
                                    {{ feature.name }}
                                </span>
                            </label>
                        </div>
                    </InputSection>
                </div>
            </div>

            <div class="mb-8">
                <div class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]">
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-info-circle mr-2"></i>
                        กิจกรรมสุขภาพ
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        เลือกกิจกรรมสุขภาพที่โดดเด่นหรือมีให้บริการ ณ
                        สถานที่ท่องเที่ยวแห่งนี้
                    </p>
                </div>
                <div class="grid grid-cols-2">
                    <InputSection class="col-span-2" name="activities" :errorMessage="form.errors.activities" required
                        noLabel>
                        <div v-for="feature in featureActivities" :key="feature.id" class="flex items-center gap-2">
                            <Checkbox v-model="form.activities" :inputId="feature.slug" :name="feature.name"
                                :value="feature.id" />
                            <label :for="feature.slug">
                                <span class="opacity-80">
                                    {{ feature.name }}
                                </span>
                            </label>
                        </div>
                    </InputSection>
                </div>
            </div>

            <div class="mb-8">
                <div class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]">
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-info-circle mr-2"></i>
                        สภาพแวดล้อมและบรรยากาศ
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        เลือกสภาพแวดล้อมและบรรยากาศที่ให้บริการ ณ
                        สถานที่ท่องเที่ยวแห่งนี้
                    </p>
                </div>
                <div class="grid grid-cols-2">
                    <InputSection class="col-span-2" name="environments" :errorMessage="form.errors.environments"
                        required noLabel>
                        <div v-for="feature in featureEnvironments" :key="feature.id" class="flex items-center gap-2">
                            <Checkbox v-model="form.environments" :inputId="feature.slug" :name="feature.name"
                                :value="feature.id" />
                            <label :for="feature.slug">
                                <span class="opacity-80">
                                    {{ feature.name }}
                                </span>
                            </label>
                        </div>
                    </InputSection>
                </div>
            </div>

            <div class="mb-8">
                <div class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]">
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-info-circle mr-2"></i>
                        ระยะเวลาและความเข้มข้นของโปรแกรม
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        เลือกระยะเวลาและความเข้มข้นของโปรแกรมที่ให้บริการ ณ
                        สถานที่ท่องเที่ยวแห่งนี้
                    </p>
                </div>
                <div class="grid grid-cols-2">
                    <InputSection class="col-span-2" name="durationIntensity"
                        :errorMessage="form.errors.durationIntensity" required noLabel>
                        <div v-for="feature in featureDurationIntensities" :key="feature.id"
                            class="flex items-center gap-2">
                            <RadioButton v-model="form.durationIntensity" :inputId="feature.slug" :name="feature.name"
                                :value="feature.id" />
                            <label :for="feature.slug">
                                <span class="opacity-80">
                                    {{ feature.name }}
                                </span>
                            </label>
                        </div>
                    </InputSection>
                </div>
            </div>

            <div class="mb-8">
                <div class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]">
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-info-circle mr-2"></i>
                        งบประมาณและที่พัก
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        เลือกงบประมาณและที่พักที่ให้บริการ ณ
                        สถานที่ท่องเที่ยวแห่งนี้
                    </p>
                </div>
                <div class="grid grid-cols-2">
                    <InputSection class="col-span-2" name="budgetAccommodation"
                        :errorMessage="form.errors.budgetAccommodation" required noLabel>
                        <div v-for="feature in featureBudgetAccommodations" :key="feature.id"
                            class="flex items-center gap-2">
                            <RadioButton v-model="form.budgetAccommodation" :inputId="feature.slug" :name="feature.name"
                                :value="feature.id" />
                            <label :for="feature.slug">
                                <span class="opacity-80">
                                    {{ feature.name }}
                                </span>
                            </label>
                        </div>
                    </InputSection>
                </div>
            </div>

            <div class="mb-8">
                <div class="mb-4 pb-2 border-b border-[var(--p-menu-border-color)]">
                    <h2 class="text-xl font-semibold">
                        <i class="pi pi-info-circle mr-2"></i>
                        Keywords
                    </h2>
                    <p class="text-sm opacity-75 mt-1">
                        กรอก Keywords ที่ใช้ในการค้นหาสถานที่ท่องเที่ยวแห่งนี้
                    </p>
                </div>

                <div class="grid grid-cols-2">
                    <InputSection class="col-span-2" name="keywords" :errorMessage="form.errors.keywords" required
                        noLabel>
                        <Textarea id="keywords" name="keywords" v-model="handleKeywords" rows="10"
                            placeholder="ภูเขา, ท่องเที่ยว, ที่พัก" />
                    </InputSection>
                </div>
            </div>

            <FormControl :backRoute="route('admin.destinations.show', props.destination.id)
                " :processing="form.processing" @reset="form.reset()" />
        </form>
    </AdminLayout>
</template>
