<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Button, Card, Chip, Tag } from "primevue";
import { Link, usePage } from "@inertiajs/vue3";
import { computed, ref, onMounted, onUnmounted } from "vue";

const props = defineProps({
    featuredDestinations: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => [],
    },
    stats: {
        type: Object,
        default: () => ({}),
    },
});

const page = usePage();
const isAuthenticated = computed(() => page.props.auth.user);

// Navbar scroll effect
const isScrolled = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 50;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

const categoryIcons = {
    สปาและนวด: "pi-heart",
    โยคะและสมาธิ: "pi-sun",
    บ่อน้ำพุร้อนและออนเซ็น: "pi-bolt",
    ศูนย์สุขภาพและเวลเนสรีทรีท: "pi-star",
    คลินิกความงามและเสริมความงาม: "pi-sparkles",
    ฟิตเนสและกิจกรรมกีฬา: "pi-chart-line",
    การบำบัดทางเลือก: "pi-shield",
    โรงพยาบาลและศูนย์การแพทย์: "pi-building",
};

const getCategoryIcon = (categoryName) => {
    return categoryIcons[categoryName] || "pi-circle";
};
</script>

<template>
    <AppLayout title="ค้นพบการเดินทางเพื่อสุขภาพและความสุขของคุณ">
        <!-- Navbar -->
        <nav
            :class="[
                'fixed top-0 left-0 right-0 z-50 transition-all duration-500',
                isScrolled
                    ? 'bg-white/95 dark:bg-[var(--p-surface-900)]/95 backdrop-blur-md shadow-md'
                    : 'bg-transparent',
            ]"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16 md:h-20">
                    <!-- Logo -->
                    <Link
                        :href="route('welcome')"
                        class="flex items-center gap-2"
                    >
                        <i
                            :class="[
                                'pi pi-compass text-2xl',
                                isScrolled
                                    ? 'text-[var(--p-primary-color)]'
                                    : 'text-white',
                            ]"
                        ></i>
                        <span
                            :class="[
                                'text-xl md:text-2xl font-bold transition-colors',
                                isScrolled
                                    ? 'text-[var(--p-text-color)]'
                                    : 'text-white',
                            ]"
                        >
                            Smart Travel
                        </span>
                    </Link>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center gap-6">
                        <Link
                            :href="route('welcome')"
                            :class="[
                                'font-medium transition-colors hover:text-[var(--p-primary-color)]',
                                isScrolled
                                    ? 'text-[var(--p-text-color)]'
                                    : 'text-white',
                            ]"
                        >
                            หน้าแรก
                        </Link>
                        <Link
                            :href="route('destinations.index')"
                            :class="[
                                'font-medium transition-colors hover:text-[var(--p-primary-color)]',
                                isScrolled
                                    ? 'text-[var(--p-text-color)]'
                                    : 'text-white',
                            ]"
                        >
                            สำรวจสถานที่
                        </Link>
                        <a
                            href="#"
                            :class="[
                                'font-medium transition-colors hover:text-[var(--p-primary-color)]',
                                isScrolled
                                    ? 'text-[var(--p-text-color)]'
                                    : 'text-white',
                            ]"
                        >
                            เกี่ยวกับเรา
                        </a>
                        <a
                            href="#"
                            :class="[
                                'font-medium transition-colors hover:text-[var(--p-primary-color)]',
                                isScrolled
                                    ? 'text-[var(--p-text-color)]'
                                    : 'text-white',
                            ]"
                        >
                            ติดต่อเรา
                        </a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center gap-3">
                        <template v-if="!isAuthenticated">
                            <Button
                                label="เข้าสู่ระบบ"
                                :text="!isScrolled"
                                :outlined="isScrolled"
                                size="small"
                                asChild
                                v-slot="slotProps"
                            >
                                <Link
                                    :class="slotProps.class"
                                    :href="route('login')"
                                >
                                    เข้าสู่ระบบ
                                </Link>
                            </Button>
                            <Button
                                label="สมัครสมาชิก"
                                size="small"
                                asChild
                                v-slot="slotProps"
                            >
                                <Link
                                    :class="slotProps.class"
                                    :href="route('register')"
                                >
                                    สมัครสมาชิก
                                </Link>
                            </Button>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative text-white overflow-hidden">
            <!-- Background Image -->
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="
                    background-image: url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=2070');
                "
            ></div>

            <!-- Black Opacity Overlay -->
            <div class="absolute inset-0 bg-black/60"></div>

            <!-- Content -->
            <div
                class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24"
            >
                <div class="text-center max-w-4xl mx-auto">
                    <!-- Badge -->
                    <Chip
                        label="แพลตฟอร์มเวลเนสทราเวลอันดับ 1 ของไทย"
                        icon="pi pi-sparkles"
                        class="mb-6 bg-white/20 text-white border-white/30"
                    />

                    <!-- Main Heading -->
                    <h1
                        class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight"
                    >
                        ค้นพบการเดินทาง
                        <br class="hidden md:block" />
                        เพื่อสุขภาพและความสุข
                    </h1>

                    <!-- Subtitle -->
                    <p
                        class="text-lg md:text-xl mb-8 opacity-90 leading-relaxed"
                    >
                        ปลดปล่อยความเครียด ฟื้นฟูพลังงาน
                        และค้นพบตัวตนที่แท้จริงของคุณ
                        <br class="hidden md:block" />
                        ผ่านประสบการณ์เวลเนสระดับโลกทั่วประเทศไทย
                    </p>

                    <!-- CTA Buttons -->
                    <div
                        class="flex flex-col sm:flex-row gap-3 justify-center items-center mb-12"
                    >
                        <Button
                            v-if="!isAuthenticated"
                            label="เริ่มต้นการเดินทาง"
                            size="large"
                            severity="contrast"
                            asChild
                            v-slot="slotProps"
                        >
                            <Link
                                :class="slotProps.class"
                                :href="route('register')"
                            >
                                <i class="pi pi-compass"></i>
                                เริ่มต้นการเดินทาง
                            </Link>
                        </Button>

                        <Button
                            v-else
                            label="สำรวจสถานที่"
                            size="large"
                            severity="contrast"
                            asChild
                            v-slot="slotProps"
                        >
                            <Link
                                :class="slotProps.class"
                                :href="route('destinations.index')"
                            >
                                <i class="pi pi-compass"></i>
                                สำรวจสถานที่
                            </Link>
                        </Button>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                        <div class="text-center">
                            <div class="text-3xl md:text-4xl font-bold mb-1">
                                {{ stats.destinations }}+
                            </div>
                            <div class="text-sm opacity-80">
                                สถานที่ท่องเที่ยว
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl md:text-4xl font-bold mb-1">
                                {{ stats.provinces }}+
                            </div>
                            <div class="text-sm opacity-80">จังหวัด</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl md:text-4xl font-bold mb-1">
                                {{ stats.reviews?.toLocaleString() || 0 }}+
                            </div>
                            <div class="text-sm opacity-80">รีวิว</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl md:text-4xl font-bold mb-1">
                                {{ stats.users?.toLocaleString() || 0 }}+
                            </div>
                            <div class="text-sm opacity-80">ผู้ใช้งาน</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="bg-[var(--p-content-background)] py-12 md:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold mb-3">
                        ประเภทการท่องเที่ยวเพื่อสุขภาพ
                    </h2>
                    <p class="text-lg opacity-70 max-w-2xl mx-auto">
                        เลือกประสบการณ์ที่ตรงใจคุณ
                        จากหลากหลายรูปแบบการดูแลสุขภาพและความงาม
                    </p>
                </div>

                <!-- Categories Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <Link
                        v-for="category in categories"
                        :key="category.id"
                        :href="
                            route('destinations.index', {
                                category: category.id,
                            })
                        "
                    >
                        <Card
                            class="text-center cursor-pointer hover:shadow-lg transition-all duration-300 border border-surface-300 dark:border-surface-700"
                        >
                            <template #content>
                                <div
                                    class="flex flex-col items-center gap-3 py-2"
                                >
                                    <div
                                        class="w-14 h-14 rounded-full bg-[var(--p-primary-50)] dark:bg-[var(--p-primary-900)] flex items-center justify-center"
                                    >
                                        <i
                                            :class="
                                                'pi ' +
                                                getCategoryIcon(category.name) +
                                                ' text-2xl text-[var(--p-primary-color)]'
                                            "
                                        ></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-sm mb-1">
                                            {{ category.name }}
                                        </h3>
                                        <p
                                            class="text-xs opacity-60 line-clamp-2"
                                        >
                                            {{ category.description }}
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </Card>
                    </Link>
                </div>

                <!-- View All Button -->
                <div class="text-center mt-8">
                    <Button
                        label="ดูทุกประเภท"
                        severity="secondary"
                        outlined
                        asChild
                        v-slot="slotProps"
                    >
                        <Link
                            :class="slotProps.class"
                            :href="route('destinations.index')"
                        >
                            <i class="pi pi-arrow-right"></i>
                            ดูทุกประเภท
                        </Link>
                    </Button>
                </div>
            </div>
        </div>

        <!-- Featured Destinations Section -->
        <div class="py-12 md:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-10">
                    <Chip
                        label="แนะนำพิเศษ"
                        icon="pi pi-star-fill"
                        class="mb-4"
                    />
                    <h2 class="text-3xl md:text-4xl font-bold mb-3">
                        สถานที่แนะนำยอดนิยม
                    </h2>
                    <p class="text-lg opacity-70 max-w-2xl mx-auto">
                        คัดสรรสถานที่เวลเนสชั้นนำที่ได้รับความนิยมสูงสุด
                        พร้อมมอบประสบการณ์ที่น่าประทับใจ
                    </p>
                </div>

                <!-- Destinations Grid -->
                <div
                    v-if="featuredDestinations.length > 0"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <Link
                        v-for="destination in featuredDestinations"
                        :key="destination.id"
                        :href="route('destinations.show', destination.slug)"
                    >
                        <Card
                            class="overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-surface-300 dark:border-surface-700 h-full"
                        >
                            <template #header>
                                <div class="relative">
                                    <img
                                        :src="
                                            destination.cover_image ||
                                            '/images/placeholder.jpg'
                                        "
                                        :alt="destination.name"
                                        class="w-full h-48 object-cover"
                                    />
                                    <div class="absolute top-3 right-3">
                                        <Tag
                                            value="แนะนำ"
                                            severity="warning"
                                            icon="pi pi-star-fill"
                                        />
                                    </div>
                                    <div class="absolute bottom-3 left-3">
                                        <Chip
                                            :label="
                                                destination.category?.name ||
                                                'ทั่วไป'
                                            "
                                            class="bg-white/90 dark:bg-gray-800/90"
                                        />
                                    </div>
                                </div>
                            </template>

                            <template #content>
                                <h3 class="text-xl font-bold mb-2 line-clamp-2">
                                    {{ destination.name }}
                                </h3>

                                <div
                                    class="flex items-center gap-2 text-sm opacity-70 mb-3"
                                >
                                    <i class="pi pi-map-marker"></i>
                                    <span>{{
                                        destination.province?.name_th ||
                                        "ไม่ระบุจังหวัด"
                                    }}</span>
                                </div>

                                <p class="text-sm opacity-70 mb-4 line-clamp-2">
                                    {{ destination.short_description }}
                                </p>

                                <div
                                    class="flex items-center justify-between pt-3 border-t border-surface-300 dark:border-surface-700"
                                >
                                    <div
                                        class="flex items-center gap-3 text-sm"
                                    >
                                        <div class="flex items-center gap-1">
                                            <i
                                                class="pi pi-star-fill text-yellow-500"
                                            ></i>
                                            <span class="font-semibold">{{
                                                Number(
                                                    destination.average_rating ||
                                                        0
                                                ).toFixed(1)
                                            }}</span>
                                        </div>
                                        <div
                                            class="flex items-center gap-1 opacity-70"
                                        >
                                            <i class="pi pi-eye"></i>
                                            <span>{{
                                                (
                                                    destination.view_count || 0
                                                ).toLocaleString()
                                            }}</span>
                                        </div>
                                    </div>
                                    <Button
                                        icon="pi pi-arrow-right"
                                        severity="secondary"
                                        text
                                        rounded
                                    />
                                </div>
                            </template>
                        </Card>
                    </Link>
                </div>

                <!-- View All Button -->
                <div class="text-center mt-10">
                    <Button
                        label="สำรวจสถานที่ทั้งหมด"
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

        <!-- Features Section -->
        <div class="bg-[var(--p-content-background)] py-12 md:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-3">
                        ทำไมต้องเลือกเรา
                    </h2>
                    <p class="text-lg opacity-70 max-w-2xl mx-auto">
                        ประสบการณ์การเดินทางเพื่อสุขภาพที่ดีที่สุด
                        พร้อมเทคโนโลยี AI ที่ช่วยคัดสรรสถานที่ให้ตรงใจคุณ
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Feature 1 -->
                    <Card
                        class="text-center border border-surface-300 dark:border-surface-700"
                    >
                        <template #content>
                            <div
                                class="w-16 h-16 mx-auto mb-4 rounded-full bg-[var(--p-primary-50)] dark:bg-[var(--p-primary-900)] flex items-center justify-center"
                            >
                                <i
                                    class="pi pi-sparkles text-3xl text-[var(--p-primary-color)]"
                                ></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">
                                คำแนะนำด้วย AI
                            </h3>
                            <p class="opacity-70 leading-relaxed">
                                ระบบ AI
                                อัจฉริยะวิเคราะห์ความชอบและพฤติกรรมของคุณ
                                เพื่อแนะนำสถานที่ที่ตรงใจที่สุด
                            </p>
                        </template>
                    </Card>

                    <!-- Feature 2 -->
                    <Card
                        class="text-center border border-surface-300 dark:border-surface-700"
                    >
                        <template #content>
                            <div
                                class="w-16 h-16 mx-auto mb-4 rounded-full bg-[var(--p-primary-50)] dark:bg-[var(--p-primary-900)] flex items-center justify-center"
                            >
                                <i
                                    class="pi pi-verified text-3xl text-[var(--p-primary-color)]"
                                ></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">
                                รีวิวจากผู้ใช้จริง
                            </h3>
                            <p class="opacity-70 leading-relaxed">
                                อ่านรีวิวจากนักเดินทางจริง
                                พร้อมรูปภาพและประสบการณ์ตรงที่น่าเชื่อถือ
                            </p>
                        </template>
                    </Card>

                    <!-- Feature 3 -->
                    <Card
                        class="text-center border border-surface-300 dark:border-surface-700"
                    >
                        <template #content>
                            <div
                                class="w-16 h-16 mx-auto mb-4 rounded-full bg-[var(--p-primary-50)] dark:bg-[var(--p-primary-900)] flex items-center justify-center"
                            >
                                <i
                                    class="pi pi-map-marker text-3xl text-[var(--p-primary-color)]"
                                ></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">
                                ครอบคลุมทั่วไทย
                            </h3>
                            <p class="opacity-70 leading-relaxed">
                                สถานที่เวลเนสทุกจังหวัดทั่วประเทศไทย
                                พร้อมข้อมูลครบถ้วนและเป็นปัจจุบัน
                            </p>
                        </template>
                    </Card>

                    <!-- Feature 4 -->
                    <Card
                        class="text-center border border-surface-300 dark:border-surface-700"
                    >
                        <template #content>
                            <div
                                class="w-16 h-16 mx-auto mb-4 rounded-full bg-[var(--p-primary-50)] dark:bg-[var(--p-primary-900)] flex items-center justify-center"
                            >
                                <i
                                    class="pi pi-heart text-3xl text-[var(--p-primary-color)]"
                                ></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">
                                บันทึกสถานที่โปรด
                            </h3>
                            <p class="opacity-70 leading-relaxed">
                                เก็บรวบรวมสถานที่ที่คุณชื่นชอบ
                                และเข้าถึงได้ง่ายทุกที่ทุกเวลา
                            </p>
                        </template>
                    </Card>

                    <!-- Feature 5 -->
                    <Card
                        class="text-center border border-surface-300 dark:border-surface-700"
                    >
                        <template #content>
                            <div
                                class="w-16 h-16 mx-auto mb-4 rounded-full bg-[var(--p-primary-50)] dark:bg-[var(--p-primary-900)] flex items-center justify-center"
                            >
                                <i
                                    class="pi pi-filter text-3xl text-[var(--p-primary-color)]"
                                ></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">
                                ค้นหาแบบละเอียด
                            </h3>
                            <p class="opacity-70 leading-relaxed">
                                กรองและค้นหาด้วยเกณฑ์ที่หลากหลาย เช่น ราคา
                                สถานที่ ประเภท และอื่นๆ
                            </p>
                        </template>
                    </Card>

                    <!-- Feature 6 -->
                    <Card
                        class="text-center border border-surface-300 dark:border-surface-700"
                    >
                        <template #content>
                            <div
                                class="w-16 h-16 mx-auto mb-4 rounded-full bg-[var(--p-primary-50)] dark:bg-[var(--p-primary-900)] flex items-center justify-center"
                            >
                                <i
                                    class="pi pi-mobile text-3xl text-[var(--p-primary-color)]"
                                ></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">
                                ใช้งานง่ายทุกอุปกรณ์
                            </h3>
                            <p class="opacity-70 leading-relaxed">
                                รองรับการใช้งานบนมือถือ แท็บเล็ต
                                และคอมพิวเตอร์ได้อย่างลื่นไหล
                            </p>
                        </template>
                    </Card>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="relative text-white overflow-hidden py-12 md:py-16">
            <!-- Background Image -->
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="
                    background-image: url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=2070');
                "
            ></div>

            <!-- Black Opacity Overlay -->
            <div class="absolute inset-0 bg-black/60"></div>

            <!-- Content -->
            <div
                class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center"
            >
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    พร้อมเริ่มการเดินทางของคุณแล้วหรือยัง?
                </h2>
                <p class="text-lg md:text-xl opacity-90 mb-8 leading-relaxed">
                    เข้าร่วมกับนักเดินทางหลายพันคนที่เลือกใช้แพลตฟอร์มของเรา
                    <br class="hidden md:block" />
                    เพื่อค้นหาประสบการณ์เวลเนสที่สมบูรณ์แบบ
                </p>

                <div
                    class="flex flex-col sm:flex-row gap-3 justify-center items-center"
                >
                    <Button
                        label="สมัครสมาชิกฟรี"
                        size="large"
                        severity="contrast"
                        asChild
                        v-slot="slotProps"
                    >
                        <Link
                            :class="slotProps.class"
                            :href="route('register')"
                        >
                            <i class="pi pi-user-plus"></i>
                            สมัครสมาชิกฟรี
                        </Link>
                    </Button>

                    <Button label="ติดต่อเรา" severity="secondary" size="large">
                        <i class="pi pi-envelope"></i>
                        ติดต่อเรา
                    </Button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer
            class="bg-[var(--p-surface-900)] dark:bg-[var(--p-surface-950)] text-white py-10"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <!-- Brand -->
                    <div class="col-span-1 md:col-span-2">
                        <h3 class="text-2xl font-bold mb-3">
                            Smart Travel Search
                        </h3>
                        <p class="opacity-70 mb-4 leading-relaxed text-sm">
                            แพลตฟอร์มค้นหาและจองสถานที่ท่องเที่ยวเพื่อสุขภาพและความงามที่ดีที่สุดในประเทศไทย
                            พร้อมระบบแนะนำด้วย AI
                            ที่ช่วยคัดสรรสถานที่ให้ตรงใจคุณ
                        </p>
                        <div class="flex gap-2">
                            <Button
                                icon="pi pi-facebook"
                                severity="secondary"
                                text
                                rounded
                            />
                            <Button
                                icon="pi pi-instagram"
                                severity="secondary"
                                text
                                rounded
                            />
                            <Button
                                icon="pi pi-twitter"
                                severity="secondary"
                                text
                                rounded
                            />
                            <Button
                                icon="pi pi-youtube"
                                severity="secondary"
                                text
                                rounded
                            />
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="font-semibold mb-3 text-sm">ลิงก์ด่วน</h4>
                        <ul class="space-y-2 text-sm">
                            <li>
                                <Link
                                    :href="route('destinations.index')"
                                    class="opacity-70 hover:opacity-100 transition"
                                    >สำรวจสถานที่</Link
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="opacity-70 hover:opacity-100 transition"
                                    >เกี่ยวกับเรา</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="opacity-70 hover:opacity-100 transition"
                                    >บล็อก</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="opacity-70 hover:opacity-100 transition"
                                    >ติดต่อเรา</a
                                >
                            </li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 class="font-semibold mb-3 text-sm">ช่วยเหลือ</h4>
                        <ul class="space-y-2 text-sm">
                            <li>
                                <a
                                    href="#"
                                    class="opacity-70 hover:opacity-100 transition"
                                    >ศูนย์ช่วยเหลือ</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="opacity-70 hover:opacity-100 transition"
                                    >คำถามที่พบบ่อย</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="opacity-70 hover:opacity-100 transition"
                                    >นโยบายความเป็นส่วนตัว</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="opacity-70 hover:opacity-100 transition"
                                    >เงื่อนไขการใช้งาน</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Copyright -->
                <div
                    class="pt-6 border-t border-white/10 text-center text-sm opacity-70"
                >
                    <p>&copy; 2025 Smart Travel Search. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </AppLayout>
</template>
