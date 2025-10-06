<script setup>
import { Button } from "primevue";
import { Link } from "@inertiajs/vue3";

defineProps({
    backRoute: {
        type: String,
        required: true,
    },
    processing: {
        type: Boolean,
        required: false,
    },
});

const emit = defineEmits(["reset"]);

const handleReset = () => {
    emit("reset");
};
</script>

<template>
    <div class="flex items-center gap-2 mt-6">
        <Button severity="secondary" asChild v-slot="slotProps">
            <Link :href="backRoute" :class="slotProps.class"> ย้อนกลับ </Link>
        </Button>

        <Button
            severity="warn"
            type="button"
            icon="pi pi-refresh"
            label="รีเซ็ต"
            @click="handleReset"
        />

        <Button
            type="submit"
            icon="pi pi-save"
            label="บันทึก"
            :disabled="processing"
            :loading="processing"
        />
    </div>
</template>
