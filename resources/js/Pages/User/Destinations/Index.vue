<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Link } from "@inertiajs/vue3";
import { Button } from "primevue";
defineProps({
    destinations: {
        type: Object,
        required: true,
    },
    provinces: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <UserLayout title="สถานที่ท่องเที่ยวที่แนะนำ">
        <nav class="bg-white border-b py-2 px-10 shadow">
            <div class="flex gap-6 items-center container mx-auto">
                <img class="w-20" src="/images/logo.svg" alt="colorful-bird-illustration-gradient" />
                <ul class="flex gap-5 text-sm opacity-85">
                    <li>สถานที่ท่องเที่ยวทั้งหมด</li>
                    <li>คู่มือท่องเที่ยวรีวิวทริปเที่ยว</li>
                    <li>คู่มือท่องเที่ยว</li>
                </ul>
            </div>
        </nav>

        <div class="pb-10">
            <div class="hero-background mb-20"></div>
            <div class="container mx-auto">
                <div>
                    <h1 class="font-bold text-2xl opacity-80 mb-5">
                        ที่เที่ยวยอดนิยมในประเทศไทย
                    </h1>

                    <div>
                        <ul class="flex gap-6">
                            <li v-for="province in provinces">
                                <img class="rounded-xl size-[15rem]" :src="province.image_url" :alt="province.name" />
                                <div class="flex flex-col items-center mt-4 gap-1">
                                    <h2 class="text-lg font-bold opacity-80">
                                        {{ province.name }}
                                    </h2>
                                    <span class="opacity-75 text-sm">
                                        {{ province.destinations_count }}
                                        ที่เที่ยว
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                    <ul class="flex flex-col gap-6 mt-20 max-w-6xl">
                        <li v-for="destination in destinations">
                            <div class="grid grid-cols-5 border rounded-xl">
                                <div class="col-span-4 p-4 flex gap-4 border-r">
                                    <img class="h-[250px] w-[250px] object-cover rounded-xl"
                                        :src="destination.cover_image" :alt="destination.name" />
                                    <div class="flex flex-col">
                                        <h1 class="text-xl font-bold mb-1">
                                            {{ destination.name }}
                                        </h1>
                                        <div class="flex gap-2">
                                            <ul class="flex text-xs">
                                                <li v-for="i in Number(3)">
                                                    ⭐
                                                </li>
                                            </ul>

                                            <a class="text-blue-400 text-sm" href="/">
                                                🗺️
                                                {{ destination.province.name }}
                                                - ดูตำแหน่งบนแผนที่
                                            </a>
                                        </div>

                                        <p class="opacity-75 mt-2">
                                            {{ destination.description }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-span-1 p-4 flex flex-col justify-between ">
                                    <div class="flex justify-end gap-4">
                                        <Button severity="secondary" icon="pi pi-heart" />

                                        <div class="flex flex-col">
                                            <span>
                                                ดีเยี่ยม
                                            </span>

                                            <span class="opacity-75 text-sm">
                                                1466 รีวิว
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col justify-end items-end">
                                        <span class="opacity-75">
                                            ราคาเฉลี่ยต่อคืน
                                        </span>

                                        <span class="text-2xl font-[900] text-red-500">
                                            ฿ {{ destination.price_from }} 
                                        </span>

                                        <Button class="mt-2" size="large" label="ดูรายละเอียด" />
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<style scoped>
.hero-background {
    width: 100%;
    min-height: 20rem;
    background-size: cover;
    background-position: center;
    background-image: url("https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
}
</style>
