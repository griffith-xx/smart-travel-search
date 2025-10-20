<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Button } from "primevue";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    preference: {
        type: Object,
        default: null,
    },
});

const hasPreference = computed(() => props.preference !== null);

const personals = [
    {
        icon: "🎯",
        title: "เป้าหมายส่วนตัว",
        description: "ระบุเป้าหมายและความต้องการเฉพาะของคุณ",
    },
    {
        icon: "🏃‍♀️",
        title: "กิจกรรมที่ชื่นชอบ",
        description: "เลือกกิจกรรมที่สนใจและเหมาะกับคุณ",
    },
    {
        icon: "💰",
        title: "งบประมาณ",
        description: "แนะนำตัวเลือกที่เหมาะกับงบประมาณ",
    },
];

const rewards = [
    "คำแนะนำสถานที่ท่องเที่ยวที่เหมาะสม",
    "ข้อมูลสถานที่และกิจกรรมที่ตรงกับความต้องการ",
    "แผนการเดินทางที่ปรับแต่งเฉพาะสำหรับคุณ",
    "รับข้อเสนอพิเศษและโปรโมชั่น",
];
</script>

<template>
    <UserLayout title="ความชอบของฉัน">
        <!-- Hero Section -->
        <div class="relative text-white overflow-hidden">
            <!-- Background Image -->
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="
                    background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=2070');
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
                        <i class="pi pi-sliders-h text-5xl opacity-90"></i>
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                        ความชอบของฉัน
                    </h1>
                    <p class="text-lg md:text-xl opacity-90">
                        {{
                            hasPreference
                                ? "จัดการความชอบของคุณเพื่อรับคำแนะนำที่ดีที่สุด"
                                : "เริ่มต้นการเดินทางสู่ประสบการณ์ที่เหมาะกับคุณ"
                        }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <!-- Has Preference - Show Details -->
            <div v-if="hasPreference">
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">
                            ความชอบที่บันทึกไว้
                        </h2>
                        <p class="text-sm opacity-70">
                            อัปเดตล่าสุด:
                            {{
                                new Date(
                                    preference.updated_at
                                ).toLocaleDateString("th-TH", {
                                    year: "numeric",
                                    month: "long",
                                    day: "numeric",
                                })
                            }}
                        </p>
                    </div>
                    <Button
                        label="แก้ไขความชอบ"
                        outlined
                        asChild
                        v-slot="slotProps"
                    >
                        <Link
                            :class="slotProps.class"
                            :href="route('preferences.edit')"
                        >
                            <i class="pi pi-pencil"></i>
                            แก้ไขความชอบ
                        </Link>
                    </Button>
                </div>

                <!-- Preference Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Wellness Goals -->
                    <div
                        v-if="
                            preference.wellness_goals &&
                            preference.wellness_goals.length > 0
                        "
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                    >
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-12 h-12 rounded-full bg-[var(--p-primary-color)]/10 flex items-center justify-center text-2xl"
                            >
                                🎯
                            </div>
                            <h3 class="text-xl font-semibold">
                                เป้าหมายและแรงบันดาลใจ
                            </h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="goal in preference.wellness_goals"
                                :key="goal.id"
                                class="inline-flex items-center px-3 py-1.5 bg-[var(--p-primary-color)]/10 text-[var(--p-primary-color)] rounded-full text-sm"
                            >
                                {{ goal.name }}
                            </span>
                        </div>
                    </div>

                    <!-- Activities -->
                    <div
                        v-if="
                            preference.activities &&
                            preference.activities.length > 0
                        "
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                    >
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center text-2xl"
                            >
                                🏃‍♀️
                            </div>
                            <h3 class="text-xl font-semibold">
                                กิจกรรมที่สนใจ
                            </h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="activity in preference.activities"
                                :key="activity.id"
                                class="inline-flex items-center px-3 py-1.5 bg-green-500/10 text-green-600 dark:text-green-400 rounded-full text-sm"
                            >
                                {{ activity.name }}
                            </span>
                        </div>
                    </div>

                    <!-- Environments -->
                    <div
                        v-if="
                            preference.environments &&
                            preference.environments.length > 0
                        "
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                    >
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-2xl"
                            >
                                🌴
                            </div>
                            <h3 class="text-xl font-semibold">
                                สภาพแวดล้อมที่ชอบ
                            </h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="env in preference.environments"
                                :key="env.id"
                                class="inline-flex items-center px-3 py-1.5 bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-full text-sm"
                            >
                                {{ env.name }}
                            </span>
                        </div>
                    </div>

                    <!-- Duration Intensity -->
                    <div
                        v-if="preference.duration_intensity"
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                    >
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-12 h-12 rounded-full bg-purple-500/10 flex items-center justify-center text-2xl"
                            >
                                ⏱️
                            </div>
                            <h3 class="text-xl font-semibold">
                                ระยะเวลาและความเข้มข้น
                            </h3>
                        </div>
                        <div
                            class="bg-purple-500/10 text-purple-600 dark:text-purple-400 rounded-lg p-4"
                        >
                            <div class="font-semibold mb-1">
                                {{ preference.duration_intensity.name }}
                            </div>
                            <div
                                v-if="preference.duration_intensity.description"
                                class="text-sm opacity-80"
                            >
                                {{ preference.duration_intensity.description }}
                            </div>
                        </div>
                    </div>

                    <!-- Budget Accommodation -->
                    <div
                        v-if="preference.budget_accommodation"
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                    >
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-12 h-12 rounded-full bg-amber-500/10 flex items-center justify-center text-2xl"
                            >
                                💰
                            </div>
                            <h3 class="text-xl font-semibold">งบประมาณ</h3>
                        </div>
                        <div
                            class="bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-lg p-4"
                        >
                            <div class="font-semibold mb-1">
                                {{ preference.budget_accommodation.name }}
                            </div>
                            <div
                                v-if="
                                    preference.budget_accommodation.description
                                "
                                class="text-sm opacity-80"
                            >
                                {{
                                    preference.budget_accommodation.description
                                }}
                            </div>
                        </div>
                    </div>

                    <!-- Wellness Experience -->
                    <div
                        v-if="preference.wellness_experience"
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                    >
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-12 h-12 rounded-full bg-pink-500/10 flex items-center justify-center text-2xl"
                            >
                                ⭐
                            </div>
                            <h3 class="text-xl font-semibold">
                                ประสบการณ์ท่องเที่ยว
                            </h3>
                        </div>
                        <div
                            class="bg-pink-500/10 text-pink-600 dark:text-pink-400 rounded-lg p-4"
                        >
                            <div class="font-semibold mb-1">
                                {{ preference.wellness_experience.name }}
                            </div>
                            <div
                                v-if="
                                    preference.wellness_experience.description
                                "
                                class="text-sm opacity-80"
                            >
                                {{ preference.wellness_experience.description }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    class="mt-8 flex flex-col sm:flex-row gap-4 justify-center"
                >
                    <Button
                        label="ดูสถานที่แนะนำสำหรับฉัน"
                        size="large"
                        asChild
                        v-slot="slotProps"
                    >
                        <Link
                            :class="slotProps.class"
                            :href="route('destinations.recommended')"
                        >
                            <i class="pi pi-star"></i>
                            ดูสถานที่แนะนำสำหรับฉัน
                        </Link>
                    </Button>
                    <Button
                        label="สำรวจสถานที่ทั้งหมด"
                        severity="secondary"
                        outlined
                        size="large"
                        asChild
                        v-slot="slotProps"
                    >
                        <Link
                            :class="slotProps.class"
                            :href="route('destinations.index')"
                        >
                            <i class="pi pi-compass"></i>
                            สำรวจสถานที่ทั้งหมด
                        </Link>
                    </Button>
                </div>
            </div>

            <!-- No Preference - Welcome Screen -->
            <div v-else>
                <div
                    class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 shadow-sm p-6 md:p-10 max-w-4xl mx-auto"
                >
                    <div class="text-center mb-8">
                        <div
                            class="w-20 h-20 mx-auto mb-6 rounded-full bg-[var(--p-primary-color)]/10 flex items-center justify-center text-4xl"
                        >
                            📋
                        </div>

                        <h2 class="text-2xl md:text-3xl font-bold mb-3">
                            แบบสำรวจความต้องการส่วนบุคคล
                        </h2>

                        <p class="text-lg opacity-70 max-w-2xl mx-auto">
                            ใช้เวลาเพียง 2-3 นาที
                            เพื่อช่วยเราทำความเข้าใจความต้องการของคุณ
                            และแนะนำสถานที่ท่องเที่ยวที่เหมาะสมที่สุด
                        </p>
                    </div>

                    <!-- Feature Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div
                            v-for="personal in personals"
                            :key="personal.title"
                            class="flex flex-col items-center text-center p-6 rounded-xl border border-surface-300 dark:border-surface-700 hover:bg-[var(--p-content-hover-background)] transition"
                        >
                            <div
                                class="w-16 h-16 rounded-full bg-[var(--p-primary-color)]/10 flex items-center justify-center text-3xl mb-4"
                            >
                                {{ personal.icon }}
                            </div>
                            <h3 class="text-lg font-semibold mb-2">
                                {{ personal.title }}
                            </h3>
                            <p class="text-sm opacity-70">
                                {{ personal.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div
                        class="bg-[var(--p-primary-color)]/5 rounded-xl p-6 mb-8"
                    >
                        <h3
                            class="text-lg font-semibold mb-4 flex items-center gap-2"
                        >
                            <i class="pi pi-gift"></i>
                            <span>สิ่งที่คุณจะได้รับ</span>
                        </h3>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <li
                                v-for="reward in rewards"
                                :key="reward"
                                class="flex items-start gap-2"
                            >
                                <i
                                    class="pi pi-check-circle text-green-500 mt-1"
                                ></i>
                                <span class="opacity-80">{{ reward }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col items-center gap-4">
                        <Button
                            label="เริ่มต้นแบบสอบถาม (2-3 นาที)"
                            size="large"
                            class="w-full sm:w-auto"
                            asChild
                            v-slot="slotProps"
                        >
                            <Link
                                :class="slotProps.class"
                                :href="route('preferences.create')"
                            >
                                เริ่มต้นแบบสอบถาม (2-3 นาที)
                                <i class="pi pi-arrow-right"></i>
                            </Link>
                        </Button>

                        <Link
                            :href="route('destinations.index')"
                            class="text-sm opacity-70 hover:opacity-100 underline transition-all"
                        >
                            ข้ามขั้นตอนนี้ไปก่อน
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
