<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import RatingStars from './RatingStars.vue';
import SecondaryButton from '../SecondaryButton.vue';
import DangerButton from '../DangerButton.vue';
import axios from 'axios';

const props = defineProps({
    review: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['reviewUpdated', 'reviewDeleted', 'edit']);

const page = usePage();
const currentUser = computed(() => page.props.auth?.user);

const isOwner = computed(() => {
    return currentUser.value?.id === props.review.user_id;
});

const localReview = ref({ ...props.review });
const isVoting = ref(false);
const isDeleting = ref(false);

const userProfilePhoto = computed(() => {
    return props.review.user?.profile_photo_url || props.review.user?.profile_photo_path || '/images/default-avatar.png';
});

const formattedDate = computed(() => {
    return new Date(props.review.created_at).toLocaleDateString('th-TH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
});

const formattedVisitDate = computed(() => {
    if (!props.review.visit_date) {
        return null;
    }
    return new Date(props.review.visit_date).toLocaleDateString('th-TH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
});

const voteHelpful = async (isHelpful) => {
    if (!currentUser.value || isVoting.value) {
        return;
    }

    isVoting.value = true;

    try {
        const response = await axios.post(route('reviews.helpful', props.review.id), {
            is_helpful: isHelpful,
        });

        if (response.data.success) {
            localReview.value.user_vote = response.data.user_vote;
            localReview.value.helpful_count = response.data.helpful_count;
            localReview.value.not_helpful_count = response.data.not_helpful_count;
            emit('reviewUpdated', localReview.value);
        }
    } catch (error) {
        console.error('Error voting:', error);
    } finally {
        isVoting.value = false;
    }
};

const deleteReview = async () => {
    if (!confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรีวิวนี้?')) {
        return;
    }

    isDeleting.value = true;

    try {
        const response = await axios.delete(route('reviews.destroy', props.review.id));

        if (response.data.success) {
            emit('reviewDeleted', props.review.id);
        }
    } catch (error) {
        console.error('Error deleting review:', error);
        alert('เกิดข้อผิดพลาดในการลบรีวิว');
    } finally {
        isDeleting.value = false;
    }
};

const editReview = () => {
    emit('edit', props.review);
};
</script>

<template>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <img
                    :src="userProfilePhoto"
                    :alt="review.user?.name"
                    class="w-12 h-12 rounded-full object-cover"
                />
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white">
                        {{ review.user?.name }}
                    </h4>
                    <div class="flex items-center gap-2 mt-1">
                        <RatingStars
                            :model-value="review.rating"
                            :readonly="true"
                            size="sm"
                        />
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ formattedDate }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions for owner -->
            <div v-if="isOwner" class="flex gap-2">
                <button
                    @click="editReview"
                    class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"
                >
                    แก้ไข
                </button>
                <button
                    @click="deleteReview"
                    :disabled="isDeleting"
                    class="text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300"
                >
                    {{ isDeleting ? 'กำลังลบ...' : 'ลบ' }}
                </button>
            </div>
        </div>

        <!-- Featured Badge -->
        <div v-if="review.is_featured" class="mb-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                รีวิวเด่น
            </span>
        </div>

        <!-- Visit Date -->
        <div v-if="formattedVisitDate" class="text-sm text-gray-600 dark:text-gray-400 mb-3">
            <span class="font-medium">เยี่ยมชมเมื่อ:</span> {{ formattedVisitDate }}
        </div>

        <!-- Title -->
        <h3 v-if="review.title" class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
            {{ review.title }}
        </h3>

        <!-- Comment -->
        <p class="text-gray-700 dark:text-gray-300 mb-4 whitespace-pre-line">
            {{ review.comment }}
        </p>

        <!-- Edited Badge -->
        <div v-if="review.is_edited" class="text-xs text-gray-500 dark:text-gray-400 mb-3">
            แก้ไขเมื่อ {{ new Date(review.edited_at).toLocaleDateString('th-TH') }}
        </div>

        <!-- Admin Response -->
        <div v-if="review.admin_response" class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 mb-4">
            <p class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-1">
                ตอบกลับจากผู้ดูแลระบบ
            </p>
            <p class="text-sm text-blue-800 dark:text-blue-200">
                {{ review.admin_response }}
            </p>
            <p class="text-xs text-blue-600 dark:text-blue-400 mt-2">
                {{ new Date(review.admin_response_at).toLocaleDateString('th-TH') }}
            </p>
        </div>

        <!-- Helpful Section -->
        <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <span class="text-sm text-gray-600 dark:text-gray-400">
                รีวิวนี้เป็นประโยชน์หรือไม่?
            </span>

            <div class="flex gap-2">
                <button
                    @click="voteHelpful(true)"
                    :disabled="isVoting || !currentUser"
                    class="flex items-center gap-1 px-3 py-1.5 rounded-md text-sm transition-colors"
                    :class="[
                        localReview.user_vote === true
                            ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                            : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600',
                        (!currentUser || isVoting) && 'opacity-50 cursor-not-allowed'
                    ]"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                    <span>เป็นประโยชน์</span>
                    <span v-if="localReview.helpful_count > 0" class="font-medium">
                        ({{ localReview.helpful_count }})
                    </span>
                </button>

                <button
                    @click="voteHelpful(false)"
                    :disabled="isVoting || !currentUser"
                    class="flex items-center gap-1 px-3 py-1.5 rounded-md text-sm transition-colors"
                    :class="[
                        localReview.user_vote === false
                            ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                            : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600',
                        (!currentUser || isVoting) && 'opacity-50 cursor-not-allowed'
                    ]"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" />
                    </svg>
                    <span>ไม่เป็นประโยชน์</span>
                    <span v-if="localReview.not_helpful_count > 0" class="font-medium">
                        ({{ localReview.not_helpful_count }})
                    </span>
                </button>
            </div>
        </div>
    </div>
</template>
