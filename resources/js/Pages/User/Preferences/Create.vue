<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { Checkbox, Button, RadioButton } from "primevue";
import InputError from "@/Components/InputError.vue";

defineProps({
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
    featureWellnessExperiences: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    wellnessGoals: [],
    activities: [],
    environments: [],
    durationIntensity: null,
    budgetAccommodation: null,
    wellnessExperience: null,
});

const submit = () => {
    form.post(route("preferences.store"));
};
</script>

<template>
    <UserLayout title="แบบสำรวจความชอบของคุณ">
        <!-- Hero Section -->
        <div class="relative text-white overflow-hidden">
            <!-- Background Image -->
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="
                    background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070');
                "
            ></div>

            <!-- Black Opacity Overlay -->
            <div class="absolute inset-0 bg-black/60"></div>

            <!-- Content -->
            <div
                class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16"
            >
                <div class="text-center max-w-3xl mx-auto">
                    <div class="mb-4">
                        <i class="pi pi-heart text-5xl opacity-90"></i>
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                        แบบสำรวจความชอบของคุณ
                    </h1>
                    <p class="text-lg md:text-xl opacity-90">
                        ช่วยเราทำความเข้าใจความต้องการของคุณเพื่อแนะนำสถานที่ท่องเที่ยวที่เหมาะสมที่สุด
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <form
                @submit.prevent="submit"
                class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 shadow-sm p-6 md:p-8 lg:p-10"
            >
                <div class="space-y-10">
                    <!-- Question 1: Wellness Goals -->
                    <div class="space-y-4">
                        <div
                            class="flex items-start gap-4 pb-4 border-b border-surface-300 dark:border-surface-700"
                        >
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-full bg-[var(--p-primary-color)] text-white flex items-center justify-center font-semibold text-lg"
                            >
                                1
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl md:text-2xl font-semibold mb-2">
                                    เป้าหมายและแรงบันดาลใจในการท่องเที่ยวเชิงสุขภาพ
                                </h2>
                                <p class="text-sm md:text-base opacity-70">
                                    คุณมีเป้าหมายหลักอะไรในการเดินทางครั้งนี้?
                                    (เลือกได้มากกว่า 1 ข้อ)
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pl-0 md:pl-14">
                            <div
                                v-for="feature in featureWellnessGoals"
                                :key="feature.id"
                                class="flex items-center gap-3 p-3 rounded-lg hover:bg-[var(--p-content-hover-background)] transition cursor-pointer"
                            >
                                <Checkbox
                                    v-model="form.wellnessGoals"
                                    :inputId="feature.slug"
                                    :name="feature.name"
                                    :value="feature.id"
                                />
                                <label
                                    :for="feature.slug"
                                    class="cursor-pointer flex-1"
                                >
                                    <span class="opacity-90">
                                        {{ feature.name }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <InputError
                            :message="form.errors.wellnessGoals"
                            class="pl-0 md:pl-14"
                        />
                    </div>

                    <!-- Question 2: Activities -->
                    <div class="space-y-4">
                        <div
                            class="flex items-start gap-4 pb-4 border-b border-surface-300 dark:border-surface-700"
                        >
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-full bg-[var(--p-primary-color)] text-white flex items-center justify-center font-semibold text-lg"
                            >
                                2
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl md:text-2xl font-semibold mb-2">
                                    กิจกรรมสุขภาพที่สนใจ
                                </h2>
                                <p class="text-sm md:text-base opacity-70">
                                    คุณสนใจกิจกรรมประเภทไหน? (เลือกได้มากกว่า 1
                                    ข้อ)
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pl-0 md:pl-14">
                            <div
                                v-for="feature in featureActivities"
                                :key="feature.id"
                                class="flex items-center gap-3 p-3 rounded-lg hover:bg-[var(--p-content-hover-background)] transition cursor-pointer"
                            >
                                <Checkbox
                                    v-model="form.activities"
                                    :inputId="feature.slug"
                                    :name="feature.name"
                                    :value="feature.id"
                                />
                                <label
                                    :for="feature.slug"
                                    class="cursor-pointer flex-1"
                                >
                                    <span class="opacity-90">
                                        {{ feature.name }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <InputError
                            :message="form.errors.activities"
                            class="pl-0 md:pl-14"
                        />
                    </div>

                    <!-- Question 3: Environments -->
                    <div class="space-y-4">
                        <div
                            class="flex items-start gap-4 pb-4 border-b border-surface-300 dark:border-surface-700"
                        >
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-full bg-[var(--p-primary-color)] text-white flex items-center justify-center font-semibold text-lg"
                            >
                                3
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl md:text-2xl font-semibold mb-2">
                                    สภาพแวดล้อมและบรรยากาศที่ชื่นชอบ
                                </h2>
                                <p class="text-sm md:text-base opacity-70">
                                    คุณชอบสภาพแวดล้อมแบบไหน? (เลือกได้มากกว่า 1
                                    ข้อ)
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pl-0 md:pl-14">
                            <div
                                v-for="feature in featureEnvironments"
                                :key="feature.id"
                                class="flex items-start gap-3 p-3 rounded-lg hover:bg-[var(--p-content-hover-background)] transition cursor-pointer"
                            >
                                <Checkbox
                                    v-model="form.environments"
                                    :inputId="feature.slug"
                                    :name="feature.name"
                                    :value="feature.id"
                                    class="mt-1"
                                />
                                <label
                                    :for="feature.slug"
                                    class="cursor-pointer flex-1"
                                >
                                    <div class="opacity-90 mb-1">
                                        {{ feature.name }}
                                    </div>
                                    <div
                                        v-if="feature.description"
                                        class="text-sm opacity-60"
                                    >
                                        {{ feature.description }}
                                    </div>
                                </label>
                            </div>
                        </div>

                        <InputError
                            :message="form.errors.environments"
                            class="pl-0 md:pl-14"
                        />
                    </div>

                    <!-- Question 4: Duration Intensity -->
                    <div class="space-y-4">
                        <div
                            class="flex items-start gap-4 pb-4 border-b border-surface-300 dark:border-surface-700"
                        >
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-full bg-[var(--p-primary-color)] text-white flex items-center justify-center font-semibold text-lg"
                            >
                                4
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl md:text-2xl font-semibold mb-2">
                                    ระยะเวลาและความเข้มข้นของโปรแกรม
                                </h2>
                                <p class="text-sm md:text-base opacity-70">
                                    คุณมีเวลาสำหรับการเดินทางครั้งนี้กี่วัน?
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3 pl-0 md:pl-14">
                            <div
                                v-for="feature in featureDurationIntensities"
                                :key="feature.id"
                                class="flex items-start gap-3 p-3 rounded-lg hover:bg-[var(--p-content-hover-background)] transition cursor-pointer"
                            >
                                <RadioButton
                                    v-model="form.durationIntensity"
                                    :inputId="feature.slug"
                                    :name="feature.name"
                                    :value="feature.id"
                                    class="mt-1"
                                />
                                <label
                                    :for="feature.slug"
                                    class="cursor-pointer flex-1"
                                >
                                    <div class="opacity-90 mb-1">
                                        {{ feature.name }}
                                    </div>
                                    <div
                                        v-if="feature.description"
                                        class="text-sm opacity-60"
                                    >
                                        {{ feature.description }}
                                    </div>
                                </label>
                            </div>
                        </div>

                        <InputError
                            :message="form.errors.durationIntensity"
                            class="pl-0 md:pl-14"
                        />
                    </div>

                    <!-- Question 5: Budget Accommodation -->
                    <div class="space-y-4">
                        <div
                            class="flex items-start gap-4 pb-4 border-b border-surface-300 dark:border-surface-700"
                        >
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-full bg-[var(--p-primary-color)] text-white flex items-center justify-center font-semibold text-lg"
                            >
                                5
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl md:text-2xl font-semibold mb-2">
                                    งบประมาณและที่พัก
                                </h2>
                                <p class="text-sm md:text-base opacity-70">
                                    งบประมาณโดยประมาณต่อคนสำหรับการเดินทางครั้งนี้?
                                    (รวมที่พัก อาหาร กิจกรรม)
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3 pl-0 md:pl-14">
                            <div
                                v-for="feature in featureBudgetAccommodations"
                                :key="feature.id"
                                class="flex items-start gap-3 p-3 rounded-lg hover:bg-[var(--p-content-hover-background)] transition cursor-pointer"
                            >
                                <RadioButton
                                    v-model="form.budgetAccommodation"
                                    :inputId="feature.slug"
                                    :name="feature.name"
                                    :value="feature.id"
                                    class="mt-1"
                                />
                                <label
                                    :for="feature.slug"
                                    class="cursor-pointer flex-1"
                                >
                                    <div class="opacity-90 mb-1">
                                        {{ feature.name }}
                                    </div>
                                    <div
                                        v-if="feature.description"
                                        class="text-sm opacity-60"
                                    >
                                        {{ feature.description }}
                                    </div>
                                </label>
                            </div>
                        </div>

                        <InputError
                            :message="form.errors.budgetAccommodation"
                            class="pl-0 md:pl-14"
                        />
                    </div>

                    <!-- Question 6: Wellness Experience -->
                    <div class="space-y-4">
                        <div
                            class="flex items-start gap-4 pb-4 border-b border-surface-300 dark:border-surface-700"
                        >
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-full bg-[var(--p-primary-color)] text-white flex items-center justify-center font-semibold text-lg"
                            >
                                6
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl md:text-2xl font-semibold mb-2">
                                    ประสบการณ์ท่องเที่ยวเชิงสุขภาพ
                                </h2>
                                <p class="text-sm md:text-base opacity-70">
                                    คุณเคยทำการท่องเที่ยวเชิงสุขภาพมาก่อนหรือไม่?
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3 pl-0 md:pl-14">
                            <div
                                v-for="feature in featureWellnessExperiences"
                                :key="feature.id"
                                class="flex items-start gap-3 p-3 rounded-lg hover:bg-[var(--p-content-hover-background)] transition cursor-pointer"
                            >
                                <RadioButton
                                    v-model="form.wellnessExperience"
                                    :inputId="feature.slug"
                                    :name="feature.name"
                                    :value="feature.id"
                                    class="mt-1"
                                />
                                <label
                                    :for="feature.slug"
                                    class="cursor-pointer flex-1"
                                >
                                    <div class="opacity-90 mb-1">
                                        {{ feature.name }}
                                    </div>
                                    <div
                                        v-if="feature.description"
                                        class="text-sm opacity-60"
                                    >
                                        {{ feature.description }}
                                    </div>
                                </label>
                            </div>
                        </div>

                        <InputError
                            :message="form.errors.wellnessExperience"
                            class="pl-0 md:pl-14"
                        />
                    </div>
                </div>

                <!-- Form Actions -->
                <div
                    class="mt-10 pt-8 border-t border-surface-300 dark:border-surface-700 flex flex-col sm:flex-row items-center justify-between gap-4"
                >
                    <Button
                        type="submit"
                        label="ส่งแบบสอบถาม"
                        icon="pi pi-check"
                        size="large"
                        :disabled="form.processing"
                        :loading="form.processing"
                        class="w-full sm:w-auto"
                    />

                    <Link
                        :href="route('destinations.index')"
                        class="text-sm opacity-70 hover:opacity-100 underline transition-all"
                    >
                        ข้ามขั้นตอนนี้ไปก่อน
                    </Link>
                </div>
            </form>
        </div>
    </UserLayout>
</template>
