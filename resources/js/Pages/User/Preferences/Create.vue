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
    <UserLayout title="แบบสำรวจการท่องเที่ยวเชิงสุขภาพ">
        <div class="p-10">
            <div class="flex flex-col justify-center items-center mb-6">
                <h1 class="text-3xl font-bold">
                    แบบสำรวจการท่องเที่ยวเชิงสุขภาพ
                </h1>
                <p class="opacity-80">
                    ช่วยเราทำความเข้าใจความต้องการของคุณเพื่อแนะนำการเดินทางที่เหมาะสมที่สุด
                </p>
            </div>
            <form
                class="md:border-l-[4px]md:border-primary md:shadow-lg p-2 lg:p-8 md:rounded-xl mt-4 max-w-4xl mx-auto"
                @submit.prevent="submit"
            >
                <div class="space-y-8">
                    <div class="space-y-4">
                        <div
                            class="flex flex-col md:flex-row items-start md:items-center gap-2"
                        >
                            <div
                                class="size-8 rounded-full bg-primary text-white flex justify-center items-center"
                            >
                                1
                            </div>
                            <h2 class="text-2xl font-semibold opacity-90">
                                เป้าหมายและแรงบันดาลใจในการท่องเที่ยวเชิงสุขภาพ
                            </h2>
                        </div>

                        <p class="opacity-70">
                            คุณมีเป้าหมายหลักอะไรในการเดินทางครั้งนี้?
                            (เลือกได้มากกว่า 1 ข้อ)
                        </p>

                        <div class="space-y-2">
                            <div
                                v-for="feature in featureWellnessGoals"
                                :key="feature.id"
                                class="flex items-center gap-2"
                            >
                                <Checkbox
                                    v-model="form.wellnessGoals"
                                    :inputId="feature.slug"
                                    :name="feature.name"
                                    :value="feature.id"
                                />
                                <label :for="feature.slug">
                                    <span class="opacity-80">
                                        {{ feature.name }}
                                    </span>

                                    <span v-if="feature.icon" class="ml-2">
                                        {{ feature.icon }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <InputError
                            :message="form.errors.wellnessGoals"
                            class="mt-2"
                        />
                    </div>
                    <div class="space-y-4">
                        <div
                            class="flex flex-col md:flex-row items-start md:items-center gap-2"
                        >
                            <div
                                class="size-8 rounded-full bg-primary text-white flex justify-center items-center"
                            >
                                2
                            </div>
                            <h2 class="text-2xl font-semibold opacity-90">
                                กิจกรรมสุขภาพที่สนใจ
                            </h2>
                        </div>

                        <p class="opacity-70">
                            คุณสนใจกิจกรรมประเภทไหน? (เลือกได้มากกว่า 1 ข้อ)
                        </p>

                        <div class="space-y-2">
                            <div
                                v-for="feature in featureActivities"
                                :key="feature.id"
                                class="flex items-center gap-2"
                            >
                                <Checkbox
                                    v-model="form.activities"
                                    :inputId="feature.slug"
                                    :name="feature.name"
                                    :value="feature.id"
                                />
                                <label :for="feature.slug">
                                    <span class="opacity-80">
                                        {{ feature.name }}
                                    </span>

                                    <span v-if="feature.icon" class="ml-2">
                                        {{ feature.icon }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <InputError
                            :message="form.errors.activities"
                            class="mt-2"
                        />
                    </div>
                    <div class="space-y-4">
                        <div
                            class="flex flex-col md:flex-row items-start md:items-center gap-2"
                        >
                            <div
                                class="size-8 rounded-full bg-primary text-white flex justify-center items-center"
                            >
                                3
                            </div>
                            <h2 class="text-2xl font-semibold opacity-90">
                                สภาพแวดล้อมและบรรยากาศที่ชื่นชอบ
                            </h2>
                        </div>

                        <p class="opacity-70">
                            คุณชอบสภาพแวดล้อมแบบไหน? (เลือกได้มากกว่า 1 ข้อ)
                        </p>

                        <div class="space-y-2">
                            <div
                                v-for="feature in featureEnvironments"
                                :key="feature.id"
                                class="flex items-center gap-2"
                            >
                                <Checkbox
                                    v-model="form.environments"
                                    :inputId="feature.slug"
                                    :name="feature.name"
                                    :value="feature.id"
                                />
                                <label :for="feature.slug">
                                    <span class="opacity-80">
                                        {{ feature.name }}
                                    </span>

                                    <span v-if="feature.icon" class="ml-2">
                                        {{ feature.icon }}
                                    </span>

                                    <span
                                        v-if="feature.description"
                                        class="ml-2 opacity-60 text-sm"
                                    >
                                        {{ feature.description }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <InputError
                            :message="form.errors.environments"
                            class="mt-2"
                        />
                    </div>
                    <div class="space-y-4">
                        <div
                            class="flex flex-col md:flex-row items-start md:items-center gap-2"
                        >
                            <div
                                class="size-8 rounded-full bg-primary text-white flex justify-center items-center"
                            >
                                4
                            </div>
                            <h2 class="text-2xl font-semibold opacity-90">
                                ระยะเวลาและความเข้มข้นของโปรแกรม
                            </h2>
                        </div>

                        <p class="opacity-70">
                            คุณมีเวลาสำหรับการเดินทางครั้งนี้กี่วัน?
                        </p>

                        <div class="space-y-2">
                            <div
                                v-for="feature in featureDurationIntensities"
                                :key="feature.id"
                                class="flex items-center gap-2"
                            >
                                <RadioButton
                                    v-model="form.durationIntensity"
                                    :inputId="feature.slug"
                                    :name="feature.name"
                                    :value="feature.id"
                                />
                                <label :for="feature.slug">
                                    <span class="opacity-80">
                                        {{ feature.name }}
                                    </span>

                                    <span v-if="feature.icon" class="ml-2">
                                        {{ feature.icon }}
                                    </span>

                                    <span
                                        v-if="feature.description"
                                        class="ml-2 opacity-60 text-sm"
                                    >
                                        {{ feature.description }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <InputError
                            :message="form.errors.durationIntensity"
                            class="mt-2"
                        />
                    </div>
                    <div class="space-y-4">
                        <div
                            class="flex flex-col md:flex-row items-start md:items-center gap-2"
                        >
                            <div
                                class="size-8 rounded-full bg-primary text-white flex justify-center items-center"
                            >
                                5
                            </div>
                            <h2 class="text-2xl font-semibold opacity-90">
                                งบประมาณและที่พัก
                            </h2>
                        </div>

                        <p class="opacity-70">
                            งบประมาณโดยประมาณต่อคนสำหรับการเดินทางครั้งนี้?
                            (รวมที่พัก อาหาร กิจกรรม)
                        </p>

                        <div class="space-y-2">
                            <div
                                v-for="feature in featureBudgetAccommodations"
                                :key="feature.id"
                                class="flex items-center gap-2"
                            >
                                <RadioButton
                                    v-model="form.budgetAccommodation"
                                    :inputId="feature.slug"
                                    :name="feature.name"
                                    :value="feature.id"
                                />
                                <label :for="feature.slug">
                                    <span class="opacity-80">
                                        {{ feature.name }}
                                    </span>

                                    <span v-if="feature.icon" class="ml-2">
                                        {{ feature.icon }}
                                    </span>

                                    <span
                                        v-if="feature.description"
                                        class="ml-2 opacity-60 text-sm"
                                    >
                                        {{ feature.description }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <InputError
                            :message="form.errors.budgetAccommodation"
                            class="mt-2"
                        />
                    </div>
                    <div class="space-y-4">
                        <div
                            class="flex flex-col md:flex-row items-start md:items-center gap-2"
                        >
                            <div
                                class="size-8 rounded-full bg-primary text-white flex justify-center items-center"
                            >
                                6
                            </div>
                            <h2 class="text-2xl font-semibold opacity-90">
                                ประสบการณ์ท่องเที่ยวเชิงสุขภาพ
                            </h2>
                        </div>

                        <p class="opacity-70">
                            คุณเคยทำการท่องเที่ยวเชิงสุขภาพมาก่อนหรือไม่?
                        </p>

                        <div class="space-y-2">
                            <div
                                v-for="feature in featureWellnessExperiences"
                                :key="feature.id"
                                class="flex items-center gap-2"
                            >
                                <RadioButton
                                    v-model="form.wellnessExperience"
                                    :inputId="feature.slug"
                                    :name="feature.name"
                                    :value="feature.id"
                                />
                                <label :for="feature.slug">
                                    <span class="opacity-80">
                                        {{ feature.name }}
                                    </span>

                                    <span v-if="feature.icon" class="ml-2">
                                        {{ feature.icon }}
                                    </span>

                                    <span
                                        v-if="feature.description"
                                        class="ml-2 opacity-60 text-sm"
                                    >
                                        {{ feature.description }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <InputError
                            :message="form.errors.wellnessExperience"
                            class="mt-2"
                        />
                    </div>
                </div>

                <div
                    class="mt-10 flex items-center justify-between gap-4 w-full"
                >
                    <Button
                        size="large"
                        type="submit"
                        label="🚀 ส่งแบบสอบถาม"
                        :disabled="form.processing"
                        :loading="form.processing"
                    />
                    <Link
                        :href="route('destinations.index')"
                        class="opacity-70 hover:opacity-100 underline transition-all"
                    >
                        ขอฉันข้ามตอนนี้ไปก่อน
                    </Link>
                </div>
            </form>
        </div>
    </UserLayout>
</template>
