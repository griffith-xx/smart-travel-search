<script setup>
import { Button } from "primevue";
import { Link, usePage, router } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { useTheme } from "@/Composables/useTheme";

const { theme, setTheme } = useTheme();
const page = usePage();
const showMobileMenu = ref(false);

const navigations = ref([
    {
        label: "สำรวจสถานที่",
        icon: "pi pi-compass",
        route: "destinations.index",
    },
    {
        label: "แนะนำสำหรับคุณ",
        icon: "pi pi-star",
        route: "destinations.recommended",
    },
    {
        label: "สถานที่ที่บันทึก",
        icon: "pi pi-heart",
        route: "destinations.saved",
    },
    {
        label: "ความชอบของฉัน",
        icon: "pi pi-sliders-h",
        route: "preferences.index",
    },
]);

const userInitials = computed(() => {
    const name = page.props.auth.user?.name || "";
    const words = name.trim().split(/\s+/);

    if (words.length >= 2) {
        return (words[0][0] + words[1][0]).toUpperCase();
    }

    return name.substring(0, 2).toUpperCase();
});

const logout = () => {
    if (confirm("คุณต้องการออกจากระบบหรือไม่")) {
        router.post(route("logout"));
    }
};
</script>

<template>
    <nav
        class="bg-[var(--p-content-background)] border-b border-surface-300 dark:border-surface-700 sticky top-0 z-50"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center gap-8">
                    <Link
                        :href="route('destinations.index')"
                        class="flex items-center gap-2 hover:opacity-80 transition"
                    >
                        <span class="text-2xl">✈️</span>
                        <h1 class="font-bold text-xl hidden sm:block">
                            Smart Travel
                        </h1>
                    </Link>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center gap-2">
                        <Link
                            v-for="item in navigations"
                            :key="item.route"
                            :href="route(item.route)"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg transition text-sm font-medium hover:bg-[var(--p-menu-item-focus-background)]"
                            :class="{
                                'text-[var(--p-primary-color)] bg-[var(--p-primary-color)]/10':
                                    route().current(item.route),
                                'opacity-70 hover:opacity-100': !route().current(
                                    item.route,
                                ),
                            }"
                        >
                            <i :class="item.icon" class="text-sm"></i>
                            <span>{{ item.label }}</span>
                        </Link>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-3">
                    <!-- Theme Toggle -->
                    <Button
                        @click="setTheme(theme === 'light' ? 'dark' : 'light')"
                        severity="secondary"
                        text
                        rounded
                        :icon="
                            theme === 'light' ? 'pi pi-moon' : 'pi pi-sun'
                        "
                        class="hidden sm:flex"
                    />

                    <!-- User Menu (Desktop) -->
                    <div class="hidden md:flex items-center gap-3">
                        <div
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-[var(--p-content-hover-background)]"
                        >
                            <div
                                class="w-8 h-8 rounded-full bg-[var(--p-primary-color)] text-white flex items-center justify-center text-xs font-semibold"
                            >
                                {{ userInitials }}
                            </div>
                            <div class="hidden lg:block">
                                <p class="text-sm font-semibold leading-tight">
                                    {{ page.props.auth.user?.name }}
                                </p>
                                <p
                                    class="text-xs opacity-60 leading-tight truncate max-w-[150px]"
                                >
                                    {{ page.props.auth.user?.email }}
                                </p>
                            </div>
                        </div>

                        <Button
                            @click="logout"
                            icon="pi pi-sign-out"
                            severity="danger"
                            text
                            rounded
                            v-tooltip.bottom="'ออกจากระบบ'"
                        />
                    </div>

                    <!-- Mobile Menu Button -->
                    <Button
                        @click="showMobileMenu = !showMobileMenu"
                        :icon="
                            showMobileMenu ? 'pi pi-times' : 'pi pi-bars'
                        "
                        severity="secondary"
                        text
                        rounded
                        class="md:hidden"
                    />
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div
            v-if="showMobileMenu"
            class="md:hidden border-t border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
        >
            <div class="px-4 py-3 space-y-1">
                <!-- Mobile Navigation Links -->
                <Link
                    v-for="item in navigations"
                    :key="item.route"
                    :href="route(item.route)"
                    @click="showMobileMenu = false"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition"
                    :class="{
                        'text-[var(--p-primary-color)] bg-[var(--p-primary-color)]/10':
                            route().current(item.route),
                        'hover:bg-[var(--p-menu-item-focus-background)]':
                            !route().current(item.route),
                    }"
                >
                    <i :class="item.icon"></i>
                    <span class="font-medium">{{ item.label }}</span>
                </Link>

                <!-- Mobile User Info -->
                <div
                    class="flex items-center gap-3 px-3 py-3 mt-3 border-t border-surface-300 dark:border-surface-700"
                >
                    <div
                        class="w-10 h-10 rounded-full bg-[var(--p-primary-color)] text-white flex items-center justify-center font-semibold"
                    >
                        {{ userInitials }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm truncate">
                            {{ page.props.auth.user?.name }}
                        </p>
                        <p class="text-xs opacity-60 truncate">
                            {{ page.props.auth.user?.email }}
                        </p>
                    </div>
                </div>

                <!-- Mobile Actions -->
                <div class="flex gap-2 pt-2">
                    <Button
                        @click="
                            setTheme(theme === 'light' ? 'dark' : 'light')
                        "
                        severity="secondary"
                        outlined
                        :icon="
                            theme === 'light' ? 'pi pi-moon' : 'pi pi-sun'
                        "
                        :label="theme === 'light' ? 'โหมดมืด' : 'โหมดสว่าง'"
                        class="flex-1 sm:hidden"
                    />
                    <Button
                        @click="logout"
                        icon="pi pi-sign-out"
                        label="ออกจากระบบ"
                        severity="danger"
                        outlined
                        class="flex-1"
                    />
                </div>
            </div>
        </div>
    </nav>
</template>