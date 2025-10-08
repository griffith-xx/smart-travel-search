<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Button } from "primevue";
import { Link } from "@inertiajs/vue3";
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
    "คำแนะนำโปรแกรมท่องเที่ยวเชิงสุขภาพที่เหมาะสม",
    "ข้อมูลสถานที่และกิจกรรมที่ตรงกับความต้องการ",
    "แผนการเดินทางที่ปรับแต่งเฉพาะสำหรับคุณ",
    "คำปรึกษาจากผู้เชี่ยวชาญด้านสุขภาพ",
];
</script>

<template>
    <UserLayout title="เริ่มต้นการเดินทางสู่สุขภาพที่ดี">
        <div class="p-10">
            <div class="text-center mb-6">
                <h1 class="text-3xl lg:text-4xl font-bold mb-4">
                    ค้นหาโปรแกรมท่องเที่ยว <br />
                    <span class="text-primary"> เชิงสุขภาพ </span>
                    ที่เหมาะกับคุณ
                </h1>
                <p class="text-lg opacity-70 max-w-lg mx-auto text-center">
                    เริ่มต้นการเดินทางสู่สุขภาพที่ดีและความสุขภาพใจ
                    ด้วยโปรแกรมท่องเที่ยวที่ออกแบบมาเพื่อคุณโดยเฉพาะ
                </p>
            </div>
            <div
                class="md:shadow-lg md:border p-8 md:rounded-xl mt-4 max-w-4xl mx-auto"
            >
                <div>
                    <div
                        class="size-16 p-3 rounded-full bg-primary/25 flex items-center justify-center text-3xl mx-auto mb-4"
                    >
                        📋
                    </div>

                    <h2 class="text-2xl font-semibold mb-2 text-center">
                        แบบสำรวจความต้องการส่วนบุคคล
                    </h2>

                    <p class="text-lg opacity-70 max-w-lg mx-auto text-center">
                        ใช้เวลาเพียง 2-3 นาที
                        เพื่อช่วยเราทำความเข้าใจความต้องการของคุณ
                        และแนะนำโปรแกรมท่องเที่ยวเชิงสุขภาพที่เหมาะสมที่สุด
                    </p>

                    <div class="grid grid-cols-1 lg:grid-cols-3 mt-8 gap-6">
                        <div
                            v-for="personal in personals"
                            class="flex flex-col items-center justify-center rounded-lg shadow border border-gray-100/25 p-4"
                        >
                            <div
                                class="size-12 p-3 rounded-full bg-primary/25 flex items-center justify-center text-xl mx-auto mb-4"
                            >
                                {{ personal.icon }}
                            </div>
                            <h3 class="opacity-90 text-lg font-semibold mb-2">
                                {{ personal.title }}
                            </h3>
                            <p class="opacity-70 text-center">
                                {{ personal.description }}
                            </p>
                        </div>
                    </div>

                    <div class="p-6 bg-primary/10 rounded-lg my-8">
                        <h2 class="text-lg font-semibold mb-3">
                            ℹ️ สิ่งที่คุณจะได้รับ
                        </h2>
                        <ul class="flex flex-col gap-2">
                            <li
                                v-for="reward in rewards"
                                class="flex items-center gap-2"
                            >
                                <span class="text-green-500"> ✓ </span>
                                <span class="opacity-80">{{ reward }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="flex flex-col">
                        <Button v-slot="slotProps" asChild raised size="large">
                            <Link
                                :href="route('preferences.create')"
                                :class="slotProps.class"
                                class="font-bold pulse-green w-fit mx-auto"
                            >
                                🚀 เริ่มต้นแบบสอบถาม (1-3 นาที)
                            </Link>
                        </Button>

                        <Link
                            :href="route('destinations.index')"
                            class="mt-4 text-center text-sm opacity-70 hover:opacity-100 underline transition-all"
                        >
                            ขอฉันข้ามตอนนี้ไปก่อน
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
