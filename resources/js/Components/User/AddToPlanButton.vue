<script setup>
import { Button, Dialog } from "primevue";
import { ref, onMounted } from "vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    destination: {
        type: Object,
        required: true,
    },
});

const showDialog = ref(false);
const hasPlan = ref(false);
const planInfo = ref(null);
const loading = ref(false);
const form = ref({
    day_number: 1,
    notes: "",
    estimated_cost: props.destination.price_from || "",
});

const checkActivePlan = async () => {
    try {
        const response = await axios.get(route("travel-plan.active"));
        hasPlan.value = response.data.has_plan;
        planInfo.value = response.data.plan;
    } catch (error) {
        console.error("Error checking active plan:", error);
    }
};

const openDialog = () => {
    if (!hasPlan.value) {
        router.visit(route("travel-plan.index"));
        return;
    }
    showDialog.value = true;
};

const addToPlan = async () => {
    loading.value = true;
    try {
        await axios.post(route("travel-plan.items.store"), {
            destination_id: props.destination.id,
            day_number: form.value.day_number,
            notes: form.value.notes,
            estimated_cost: form.value.estimated_cost,
        });

        showDialog.value = false;
        router.reload();
        alert("เพิ่มสถานที่ลงในแผนการท่องเที่ยวเรียบร้อยแล้ว");
    } catch (error) {
        alert(
            error.response?.data?.message ||
                "ไม่สามารถเพิ่มสถานที่ได้ กรุณาลองใหม่อีกครั้ง"
        );
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    checkActivePlan();
});
</script>

<template>
    <div>
        <Button
            :label="hasPlan ? 'เพิ่มลงในแผน' : 'สร้างแผน'"
            :icon="hasPlan ? 'pi pi-plus' : 'pi pi-calendar-plus'"
            severity="secondary"
            outlined
            class="w-full"
            @click="openDialog"
        />

        <Dialog
            v-model:visible="showDialog"
            modal
            :header="`เพิ่ม ${destination.name} ลงในแผนการท่องเที่ยว`"
            :style="{ width: '32rem' }"
        >
            <div class="space-y-4">
                <div
                    v-if="planInfo"
                    class="p-4 bg-surface-50 dark:bg-surface-900 rounded-lg"
                >
                    <p class="text-sm opacity-70">แผนการท่องเที่ยว</p>
                    <p class="font-bold">{{ planInfo.name }}</p>
                    <p class="text-sm opacity-70">
                        {{ planInfo.items_count }} สถานที่
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2"
                        >วันที่ *</label
                    >
                    <input
                        v-model.number="form.day_number"
                        type="number"
                        min="1"
                        class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                        placeholder="1"
                    />
                    <p class="text-xs opacity-50 mt-1">
                        ระบุว่าต้องการไปสถานที่นี้ในวันที่เท่าไหร่
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2"
                        >ค่าใช้จ่ายประมาณการ (บาท)</label
                    >
                    <input
                        v-model.number="form.estimated_cost"
                        type="number"
                        min="0"
                        class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                        :placeholder="destination.price_from || '0'"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2"
                        >หมายเหตุ</label
                    >
                    <textarea
                        v-model="form.notes"
                        rows="3"
                        class="w-full px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-700 bg-[var(--p-content-background)]"
                        placeholder="บันทึกเพิ่มเติม..."
                    ></textarea>
                </div>
            </div>

            <template #footer>
                <div class="flex justify-end gap-2">
                    <Button
                        label="ยกเลิก"
                        severity="secondary"
                        outlined
                        @click="showDialog = false"
                    />
                    <Button
                        label="เพิ่มลงในแผน"
                        :loading="loading"
                        @click="addToPlan"
                    />
                </div>
            </template>
        </Dialog>
    </div>
</template>
