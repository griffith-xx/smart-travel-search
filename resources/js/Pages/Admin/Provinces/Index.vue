<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { Button, DataTable, Column, ToggleSwitch } from "primevue";

defineProps({
    provinces: {
        type: Object,
        required: true,
    },
    regions: {
        type: Object,
        required: true,
    },
});

const togglePopular = (id, value) => {
    router.put(
        route("admin.provinces.update", id),
        {
            is_popular: value,
        },
        {
            preserveScroll: true,
            preserveState: false,
        }
    );
};

const deleteProvince = (id) => {
    if (confirm("ยืนยันการลบ?")) {
        router.delete(route("admin.provinces.destroy", id));
    }
};
</script>

<template>
    <AdminLayout title="จังหวัดทั้งหมด">
        <div class="flex justify-between mb-5">
            <h1 class="text-2xl font-bold">จังหวัดทั้งหมด</h1>
            <Button asChild v-slot="slotProps">
                <Link
                    :class="slotProps.class"
                    :href="route('admin.provinces.create')"
                >
                    <span class="pi pi-plus"></span>
                    เพิ่มจังหวัดใหม่
                </Link>
            </Button>
        </div>
        <DataTable stripedRows showGridlines :value="provinces">
            <Column field="id" header="#"></Column>
            <Column header="รูปปก">
                <template #body="slotProps">
                    <img
                        :src="slotProps.data.image_url"
                        :alt="slotProps.data.name"
                        class="w-24 rounded"
                    />
                </template>
            </Column>
            <Column field="name" header="ชื่อ"></Column>
            <Column field="name_en" header="ชื่อ (ภาษาอังกฤษ)"></Column>
            <Column field="description" header="รายละเอียด" class="max-w-xs">
                <template #body="slotProps">
                    <div
                        class="line-clamp-2 max-w-xs"
                        :title="slotProps.data.description"
                    >
                        {{ slotProps.data.description }}
                    </div>
                </template>
            </Column>
            <Column header="ภูมิภาค">
                <template #body="Props">
                    <span>
                        {{ regions[Props.data.region] }}
                    </span>
                </template>
            </Column>

            <Column field="sort_order" header="ลำดับ" sortable></Column>
            <Column field="latitude" header="ละติจุด"></Column>
            <Column field="longitude" header="ลองติจุด"></Column>

            <Column header="การกระทำ">
                <template #body="Props">
                    <div class="flex items-center gap-2">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-xs opacity-75">ยอดฮิต</span>
                            <ToggleSwitch
                                :modelValue="Props.data.is_popular"
                                @update:modelValue="
                                    togglePopular(Props.data.id, $event)
                                "
                            />
                        </div>

                        <Button asChild severity="warn" v-slot="slotProps">
                            <Link
                                :href="
                                    route('admin.provinces.edit', Props.data.id)
                                "
                                :class="slotProps.class"
                            >
                                <span>
                                    <i class="pi pi-pencil"></i>
                                </span>
                            </Link>
                        </Button>

                        <Button
                            severity="danger"
                            @click.prevent="deleteProvince(Props.data.id)"
                            icon="pi pi-trash"
                        />
                    </div>
                </template>
            </Column>
        </DataTable>
    </AdminLayout>
</template>
