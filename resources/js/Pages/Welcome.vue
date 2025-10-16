<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import { Button } from "primevue";
import { ref, computed } from "vue";
import Card from "primevue/card";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    provinces: {
        type: Object,
        required: true,
    },
    destinations: {
        type: Object,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    },
});

const page = usePage();
const selectProvince = ref(1);

const filteredDestinations = computed(() => {
    return props.destinations.filter(
        (d) => d.province_id === selectProvince.value,
    );
});
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-white text-gray-800">
        <header class="w-full bg-white/80 backdrop-blur-lg sticky top-0 z-10">
            <nav
                class="container mx-auto px-4 lg:px-5 py-3 flex justify-between items-center"
            >
                <Link href="/" class="flex items-center gap-2">
                    <i class="pi pi-prime text-2xl text-primary"></i>
                    <span class="text-xl font-bold">Smart Travel</span>
                </Link>
                <div class="hidden md:flex items-center gap-2">
                    <Link :href="route('welcome')">
                        <Button label="หน้าแรก" text severity="secondary" />
                    </Link>
                    <Button label="เกี่ยวกับเรา" text severity="secondary" />
                </div>
                <div v-if="canLogin" class="flex items-center gap-2">
                    <Link v-if="page.props.auth.user" :href="route('dashboard')">
                        <Button label="แดชบอร์ด" size="small" />
                    </Link>
                    <template v-else>
                        <Link :href="route('login')">
                            <Button label="เข้าสู่ระบบ" text size="small" />
                        </Link>
                        <Link v-if="canRegister" :href="route('register')">
                            <Button label="ลงทะเบียน" size="small" />
                        </Link>
                    </template>
                </div>
            </nav>
        </header>

        <main>
            <!-- Hero Section -->
            <section class="relative mb-16">
                <div
                    class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center text-white p-4"
                >
                    <h1
                        class="text-4xl md:text-6xl font-extrabold tracking-tight"
                    >
                        ท่องโลกทั้งใบในราคาถูกลง
                    </h1>
                    <p class="mt-4 text-lg md:text-xl max-w-2xl">
                        ค้นหาและวางแผนการเดินทางของคุณกับเรา
                        เพื่อประสบการณ์ที่ดีที่สุด
                    </p>
                </div>
                <img
                    class="object-cover w-full h-[420px]"
                    src="/images/banner.jpg"
                    alt="banner"
                />
            </section>

            <!-- Popular Provinces Section -->
            <section class="container mx-auto px-4 lg:px-5 mb-16">
                <h2 class="text-3xl font-bold mb-6 text-center">
                    ที่เที่ยวยอดนิยมในประเทศไทย
                </h2>
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
                >
                    <div
                        v-for="province in provinces.slice(0, 8)"
                        :key="province.id"
                        class="group relative overflow-hidden rounded-lg shadow-lg transform hover:-translate-y-2 transition-transform duration-300"
                    >
                        <img
                            class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300"
                            :src="province.image_url"
                            :alt="province.name"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"
                        ></div>
                        <div
                            class="absolute bottom-0 left-0 p-4 text-white w-full"
                        >
                            <p class="text-xl font-bold">
                                {{ province.name }}
                            </p>
                            <span class="text-sm opacity-90">
                                {{ province.destinations_count }} ที่เที่ยว
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Recommended Destinations Section -->
            <section class="container mx-auto px-4 lg:px-5 pb-16">
                <h2 class="text-3xl font-bold mb-6 text-center">
                    ที่เที่ยวแนะนำสำหรับท่านโดยเฉพาะ
                </h2>
                <div
                    class="flex flex-wrap justify-center gap-2 mb-8"
                >
                    <Button
                        v-for="province in provinces"
                        :key="province.id"
                        @click="selectProvince = province.id"
                        size="small"
                        :outlined="selectProvince !== province.id"
                        :label="province.name"
                    />
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <Card
                        v-for="dest in filteredDestinations"
                        :key="dest.id"
                        class="overflow-hidden"
                    >
                        <template #header>
                            <img
                                :alt="dest.name"
                                :src="dest.cover_image"
                                class="w-full h-48 object-cover"
                            />
                        </template>
                        <template #title>
                            <p class="truncate">{{ dest.name }}</p>
                        </template>
                        <template #subtitle>
                            <div class="flex items-center gap-2 text-sm">
                                <i class="pi pi-map-marker"></i>
                                <span>{{ dest.province.name }}</span>
                            </div>
                        </template>
                        <template #content>
                            <p class="line-clamp-3 text-sm">
                                {{ dest.short_description }}
                            </p>
                        </template>
                    </Card>
                </div>
            </section>
        </main>
    </div>
</template>