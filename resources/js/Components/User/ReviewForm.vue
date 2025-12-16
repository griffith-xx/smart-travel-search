<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import RatingStars from './RatingStars.vue';
import PrimaryButton from '../PrimaryButton.vue';
import SecondaryButton from '../SecondaryButton.vue';
import InputLabel from '../InputLabel.vue';
import TextInput from '../TextInput.vue';
import InputError from '../InputError.vue';
import axios from 'axios';

const props = defineProps({
    destination: {
        type: Object,
        required: true,
    },
    existingReview: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['reviewSubmitted', 'cancel']);

const form = ref({
    rating: props.existingReview?.rating || 0,
    title: props.existingReview?.title || '',
    comment: props.existingReview?.comment || '',
    visit_date: props.existingReview?.visit_date || '',
});

const errors = ref({});
const isSubmitting = ref(false);

const isFormValid = computed(() => {
    return form.value.rating > 0 && form.value.comment.trim().length >= 10;
});

const submitReview = async () => {
    if (!isFormValid.value || isSubmitting.value) {
        return;
    }

    isSubmitting.value = true;
    errors.value = {};

    try {
        let response;

        if (props.existingReview) {
            // Update existing review
            response = await axios.put(route('reviews.update', props.existingReview.id), form.value);
        } else {
            // Create new review
            response = await axios.post(route('destinations.reviews.store', props.destination.id), form.value);
        }

        if (response.data.success) {
            emit('reviewSubmitted', response.data.review);

            // Reset form if new review
            if (!props.existingReview) {
                form.value = {
                    rating: 0,
                    title: '',
                    comment: '',
                    visit_date: '',
                };
            }
        }
    } catch (error) {
        if (error.response?.data?.errors) {
            errors.value = error.response.data.errors;
        } else {
            errors.value = { general: error.response?.data?.message || 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง' };
        }
    } finally {
        isSubmitting.value = false;
    }
};

const handleCancel = () => {
    emit('cancel');
};
</script>

<template>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">
            {{ existingReview ? 'แก้ไขรีวิว' : 'เขียนรีวิว' }}
        </h3>

        <form @submit.prevent="submitReview" class="space-y-4">
            <!-- Rating -->
            <div>
                <InputLabel value="คะแนน *" class="mb-2" />
                <RatingStars
                    v-model="form.rating"
                    size="lg"
                    :show-text="true"
                />
                <InputError :message="errors.rating?.[0]" class="mt-2" />
            </div>

            <!-- Title -->
            <div>
                <InputLabel for="title" value="หัวข้อรีวิว (ไม่บังคับ)" />
                <TextInput
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="เช่น สถานที่ดีมาก บรรยากาศสบาย"
                    maxlength="200"
                />
                <InputError :message="errors.title?.[0]" class="mt-2" />
            </div>

            <!-- Comment -->
            <div>
                <InputLabel for="comment" value="รีวิว * (อย่างน้อย 10 ตัวอักษร)" />
                <textarea
                    id="comment"
                    v-model="form.comment"
                    rows="5"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    placeholder="บอกเล่าประสบการณ์ของคุณเกี่ยวกับสถานที่นี้..."
                    maxlength="2000"
                ></textarea>
                <div class="flex justify-between items-center mt-1">
                    <InputError :message="errors.comment?.[0]" />
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ form.comment.length }}/2000
                    </span>
                </div>
            </div>

            <!-- Visit Date -->
            <div>
                <InputLabel for="visit_date" value="วันที่เยี่ยมชม (ไม่บังคับ)" />
                <TextInput
                    id="visit_date"
                    v-model="form.visit_date"
                    type="date"
                    class="mt-1 block w-full"
                    :max="new Date().toISOString().split('T')[0]"
                />
                <InputError :message="errors.visit_date?.[0]" class="mt-2" />
            </div>

            <!-- Error Message -->
            <div v-if="errors.general || errors.destination" class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md p-3">
                <p class="text-sm text-red-600 dark:text-red-400">
                    {{ errors.general?.[0] || errors.destination?.[0] }}
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 justify-end pt-2">
                <SecondaryButton
                    v-if="existingReview"
                    type="button"
                    @click="handleCancel"
                    :disabled="isSubmitting"
                >
                    ยกเลิก
                </SecondaryButton>

                <PrimaryButton
                    type="submit"
                    :disabled="!isFormValid || isSubmitting"
                    :class="{ 'opacity-50 cursor-not-allowed': !isFormValid || isSubmitting }"
                >
                    <svg
                        v-if="isSubmitting"
                        class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ isSubmitting ? 'กำลังบันทึก...' : (existingReview ? 'บันทึกการแก้ไข' : 'เผยแพร่รีวิว') }}
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>
