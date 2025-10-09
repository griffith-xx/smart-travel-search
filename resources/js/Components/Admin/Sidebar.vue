<script setup>
import { Menu, Badge, Button } from "primevue";
import { ref, computed } from "vue";
import { Link, usePage, router } from "@inertiajs/vue3";

const page = usePage();
const navigations = ref([
    {
        label: "หน้าแรก",
        icon: "pi pi-home",
        route: "admin.dashboard",
    },
    {
        label: "จังหวัด",
        icon: "pi pi-map",
        route: "admin.provinces.index",
        badge: page.props.adminStats.provinces_count,
    },
    {
        label: "สถานที่ท่องเที่ยว",
        icon: "pi pi-globe",
        route: "admin.destinations.index",
        badge: page.props.adminStats.destinations_count,
    },
]);

const adminInitials = computed(() => {
    const name = page.props.auth.user?.name || "";
    const words = name.trim().split(/\s+/);

    if (words.length >= 2) {
        // ถ้ามี 2 คำขึ้นไป เอาตัวแรกของแต่ละคำ
        return (words[0][0] + words[1][0]).toUpperCase();
    }

    // ถ้ามีคำเดียว เอา 2 ตัวแรก
    return name.substring(0, 2).toUpperCase();
});
const logout = () => {
    if (confirm("คุณต้องการออกจากระบบหรือไม่")) {
        router.post(route("admin.logout"));
    }
};
</script>
<template>
    <div
        class="flex flex-col h-full border-r! border-[var(--p-menu-border-color)]"
    >
        <Menu
            class="border-0! rounded-none! flex-1 w-full"
            :model="navigations"
        >
            <template #item="{ item, props }">
                <Link
                    v-bind="props.action"
                    :href="route(item.route)"
                    class="flex items-center"
                >
                    <span :class="item.icon" />
                    <span>{{ item.label }}</span>
                    <Badge
                        severity="contrast"
                        v-if="item.badge"
                        class="ml-auto"
                        :value="item.badge"
                    />
                </Link>
            </template>
        </Menu>

        <div class="p-4 border-t border-[var(--p-menu-border-color)]">
            <div class="flex items-center gap-3 mb-4">
                <Avatar :label="adminInitials" shape="circle" size="large" />
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm truncate">
                        {{ page.props.auth.user?.name }}
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        {{ page.props.auth.user?.email }}
                    </p>
                </div>
            </div>

            <Button
                @click.prevent="logout"
                label="ออกจากระบบ"
                icon="pi pi-sign-out"
                type="button"
                severity="danger"
                size="small"
                class="w-full"
            />
        </div>
    </div>
</template>
