<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import DestinationCard from "@/Components/User/DestinationCard.vue";
import { Button } from "primevue";
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    recommendations: {
        type: Object,
        required: true,
    },
});

const hasRecommendations = computed(
    () => props.recommendations && props.recommendations.length > 0
);

// Get the first recommendation to show weights
const firstRecommendation = computed(() => {
    if (hasRecommendations.value) {
        return props.recommendations[0];
    }
    return null;
});

// Calculate recommendation type based on weights
const recommendationType = computed(() => {
    if (!firstRecommendation.value) return null;

    const personalizedWeight = firstRecommendation.value.personalized_weight;
    const collaborativeWeight = firstRecommendation.value.collaborative_weight;

    if (personalizedWeight === 1.0) {
        return { type: 'personalized', text: 'จากความชอบของคุณ', color: 'blue' };
    } else if (collaborativeWeight > personalizedWeight) {
        return { type: 'collaborative', text: 'จากผู้ใช้ที่มีความชอบคล้ายคุณ', color: 'purple' };
    } else {
        return { type: 'hybrid', text: 'จากความชอบและพฤติกรรมของคุณ', color: 'green' };
    }
});
</script>

<template>
    <UserLayout title="สถานที่แนะนำสำหรับคุณ">
        <!-- Hero Section -->
        <div class="relative text-white overflow-hidden">
            <!-- Background Image -->
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="
                    background-image: url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=2070');
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
                        <i class="pi pi-star-fill text-5xl opacity-90"></i>
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                        สถานที่แนะนำสำหรับคุณ
                    </h1>
                    <p class="text-lg md:text-xl opacity-90">
                        คัดสรรพิเศษตามความชอบและพฤติกรรมการท่องเที่ยวของคุณ
                    </p>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <!-- Has Recommendations -->
            <div v-if="hasRecommendations">
                <!-- Info Banner -->
                <div class="mb-8">
                    <div
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                    >
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div
                                    :class="`w-16 h-16 rounded-full bg-${recommendationType?.color}-500/10 flex items-center justify-center`"
                                >
                                    <i
                                        :class="`pi ${recommendationType?.type === 'personalized' ? 'pi-heart' : recommendationType?.type === 'collaborative' ? 'pi-users' : 'pi-sparkles'} text-3xl text-${recommendationType?.color}-500`"
                                    ></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold mb-2">
                                        {{ recommendations.length }} สถานที่แนะนำ
                                    </h2>
                                    <p class="text-sm opacity-70">
                                        <i class="pi pi-info-circle"></i>
                                        {{ recommendationType?.text }}
                                    </p>
                                    <div class="flex gap-3 mt-3 text-xs">
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                            <span class="opacity-70">ความชอบ {{ Math.round((firstRecommendation?.personalized_weight || 0) * 100) }}%</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                                            <span class="opacity-70">พฤติกรรม {{ Math.round((firstRecommendation?.collaborative_weight || 0) * 100) }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <Button
                                label="จัดการความชอบ"
                                severity="secondary"
                                outlined
                                asChild
                                v-slot="slotProps"
                            >
                                <Link
                                    :class="slotProps.class"
                                    :href="route('preferences.index')"
                                >
                                    <i class="pi pi-sliders-h"></i>
                                    จัดการความชอบ
                                </Link>
                            </Button>
                        </div>
                    </div>
                </div>

                <!-- Recommendations Grid -->
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
                >
                    <div
                        v-for="(item, index) in recommendations"
                        :key="item.destination.id"
                        class="relative"
                    >
                        <!-- Rank Badge -->
                        <div
                            v-if="index < 3"
                            class="absolute -top-2 -left-2 z-10 w-10 h-10 rounded-full flex items-center justify-center font-bold text-white shadow-lg"
                            :class="{
                                'bg-gradient-to-br from-yellow-400 to-yellow-600': index === 0,
                                'bg-gradient-to-br from-gray-300 to-gray-500': index === 1,
                                'bg-gradient-to-br from-orange-400 to-orange-600': index === 2,
                            }"
                        >
                            {{ index + 1 }}
                        </div>

                        <!-- Match Score Badge -->
                        <div
                            class="absolute top-14 right-2 z-10 bg-white/95 dark:bg-surface-800 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-md"
                        >
                            <div class="flex items-center gap-1.5">
                                <i class="pi pi-percentage text-xs text-amber-600"></i>
                                <span class="font-semibold text-sm">
                                    {{ Math.round(item.final_score * 100) }}
                                </span>
                            </div>
                        </div>

                        <DestinationCard :destination="item.destination" />
                    </div>
                </div>

                <!-- More Recommendations CTA -->
                <div class="mt-12 text-center">
                    <div
                        class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl border border-amber-500/20 p-8"
                    >
                        <h3 class="text-xl font-bold mb-3">
                            ต้องการคำแนะนำที่ดีขึ้น?
                        </h3>
                        <p class="opacity-70 mb-6 max-w-2xl mx-auto">
                            ยิ่งคุณใช้งานมากขึ้น เราจะเข้าใจความชอบของคุณได้ดีขึ้น
                            ลองกดถูกใจสถานที่ที่คุณสนใจเพื่อรับคำแนะนำที่ตรงใจมากขึ้น
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <Button
                                label="สำรวจสถานที่ทั้งหมด"
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
                            <Button
                                label="แก้ไขความชอบ"
                                severity="secondary"
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
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else>
                <div
                    class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-8 md:p-12 text-center"
                >
                    <div
                        class="w-32 h-32 mx-auto mb-6 rounded-full bg-amber-500/10 flex items-center justify-center"
                    >
                        <i class="pi pi-star text-6xl text-amber-500 opacity-50"></i>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold mb-3">
                        ยังไม่สามารถแนะนำสถานที่ได้
                    </h2>

                    <p class="text-lg opacity-70 mb-8 max-w-2xl mx-auto">
                        เราต้องการข้อมูลความชอบของคุณเพื่อแนะนำสถานที่ที่เหมาะสมที่สุด
                    </p>

                    <!-- Steps -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="flex flex-col items-center p-6 rounded-xl border border-surface-300 dark:border-surface-700">
                            <div
                                class="w-16 h-16 rounded-full bg-blue-500/10 flex items-center justify-center mb-4 text-2xl font-bold text-blue-500"
                            >
                                1
                            </div>
                            <h3 class="font-semibold mb-2">กรอกความชอบ</h3>
                            <p class="text-sm opacity-70 text-center">
                                ตอบแบบสอบถามเพื่อบอกความชอบของคุณ
                            </p>
                        </div>

                        <div class="flex flex-col items-center p-6 rounded-xl border border-surface-300 dark:border-surface-700">
                            <div
                                class="w-16 h-16 rounded-full bg-green-500/10 flex items-center justify-center mb-4 text-2xl font-bold text-green-500"
                            >
                                2
                            </div>
                            <h3 class="font-semibold mb-2">ระบบวิเคราะห์</h3>
                            <p class="text-sm opacity-70 text-center">
                                AI วิเคราะห์และหาสถานที่ที่เหมาะกับคุณ
                            </p>
                        </div>

                        <div class="flex flex-col items-center p-6 rounded-xl border border-surface-300 dark:border-surface-700">
                            <div
                                class="w-16 h-16 rounded-full bg-purple-500/10 flex items-center justify-center mb-4 text-2xl font-bold text-purple-500"
                            >
                                3
                            </div>
                            <h3 class="font-semibold mb-2">รับคำแนะนำ</h3>
                            <p class="text-sm opacity-70 text-center">
                                ดูสถานที่แนะนำที่คัดสรรมาเพื่อคุณ
                            </p>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <Button
                            label="กรอกความชอบของฉัน"
                            size="large"
                            asChild
                            v-slot="slotProps"
                        >
                            <Link
                                :class="slotProps.class"
                                :href="route('preferences.create')"
                            >
                                <i class="pi pi-heart"></i>
                                กรอกความชอบของฉัน
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
            </div>
        </div>
    </UserLayout>
</template>
