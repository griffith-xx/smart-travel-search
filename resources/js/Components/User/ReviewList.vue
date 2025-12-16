<script setup>
import { ref, computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ReviewCard from './ReviewCard.vue';
import ReviewForm from './ReviewForm.vue';
import PrimaryButton from '../PrimaryButton.vue';
import RatingStars from './RatingStars.vue';
import axios from 'axios';

const props = defineProps({
    destination: {
        type: Object,
        required: true,
    },
});

const page = usePage();
const currentUser = computed(() => page.props.auth?.user);

const reviews = ref([]);
const pagination = ref({});
const isLoading = ref(false);
const showReviewForm = ref(false);
const editingReview = ref(null);
const userHasReviewed = ref(false);

const ratingStats = computed(() => {
    const stats = {
        total: props.destination.total_reviews || 0,
        average: props.destination.average_rating || 0,
        distribution: {
            5: 0,
            4: 0,
            3: 0,
            2: 0,
            1: 0,
        },
    };

    reviews.value.forEach(review => {
        if (review.rating >= 1 && review.rating <= 5) {
            stats.distribution[review.rating]++;
        }
    });

    return stats;
});

const loadReviews = async (page = 1) => {
    isLoading.value = true;

    try {
        const response = await axios.get(route('destinations.reviews.index', props.destination.id), {
            params: { page },
        });

        reviews.value = response.data.data;
        pagination.value = {
            current_page: response.data.current_page,
            last_page: response.data.last_page,
            total: response.data.total,
        };

        // Check if current user has already reviewed
        if (currentUser.value) {
            userHasReviewed.value = reviews.value.some(
                review => review.user_id === currentUser.value.id
            );
        }
    } catch (error) {
        console.error('Error loading reviews:', error);
    } finally {
        isLoading.value = false;
    }
};

const handleReviewSubmitted = (review) => {
    showReviewForm.value = false;
    editingReview.value = null;
    loadReviews(); // Reload reviews to update the list and stats
};

const handleReviewUpdated = (review) => {
    const index = reviews.value.findIndex(r => r.id === review.id);
    if (index !== -1) {
        reviews.value[index] = review;
    }
};

const handleReviewDeleted = (reviewId) => {
    reviews.value = reviews.value.filter(r => r.id !== reviewId);
    userHasReviewed.value = false;
    loadReviews(); // Reload to update stats
};

const handleEdit = (review) => {
    editingReview.value = review;
    showReviewForm.value = true;
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

const handleCancelEdit = () => {
    editingReview.value = null;
    showReviewForm.value = false;
};

const getStarPercentage = (rating) => {
    if (ratingStats.value.total === 0) {
        return 0;
    }
    return (ratingStats.value.distribution[rating] / ratingStats.value.total) * 100;
};

onMounted(() => {
    loadReviews();
});
</script>

<template>
    <div class="space-y-6">
        <!-- Rating Summary -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">
                รีวิวและคะแนน
            </h3>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Average Rating -->
                <div class="flex flex-col items-center justify-center">
                    <div class="text-5xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ ratingStats.average > 0 ? ratingStats.average : '0.0' }}
                    </div>
                    <RatingStars
                        :model-value="ratingStats.average"
                        :readonly="true"
                        size="lg"
                    />
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        จาก {{ ratingStats.total }} รีวิว
                    </p>
                </div>

                <!-- Rating Distribution -->
                <div class="space-y-2">
                    <div v-for="rating in [5, 4, 3, 2, 1]" :key="rating" class="flex items-center gap-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 w-12">
                            {{ rating }} ดาว
                        </span>
                        <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div
                                class="bg-yellow-400 dark:bg-yellow-500 h-2 rounded-full transition-all duration-300"
                                :style="{ width: getStarPercentage(rating) + '%' }"
                            ></div>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400 w-12 text-right">
                            {{ ratingStats.distribution[rating] }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Write Review Button -->
            <div v-if="currentUser && !userHasReviewed && !showReviewForm" class="mt-6 text-center">
                <PrimaryButton @click="showReviewForm = true">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    เขียนรีวิว
                </PrimaryButton>
            </div>

            <div v-else-if="!currentUser" class="mt-6 text-center text-gray-600 dark:text-gray-400">
                <a href="/login" class="text-blue-600 dark:text-blue-400 hover:underline">
                    เข้าสู่ระบบ
                </a>
                เพื่อเขียนรีวิว
            </div>
        </div>

        <!-- Review Form -->
        <div v-if="showReviewForm">
            <ReviewForm
                :destination="destination"
                :existing-review="editingReview"
                @review-submitted="handleReviewSubmitted"
                @cancel="handleCancelEdit"
            />
        </div>

        <!-- Reviews List -->
        <div v-if="reviews.length > 0" class="space-y-4">
            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">
                รีวิวจากผู้ใช้งาน ({{ ratingStats.total }})
            </h4>

            <div class="space-y-4">
                <ReviewCard
                    v-for="review in reviews"
                    :key="review.id"
                    :review="review"
                    @review-updated="handleReviewUpdated"
                    @review-deleted="handleReviewDeleted"
                    @edit="handleEdit"
                />
            </div>

            <!-- Pagination -->
            <div v-if="pagination.last_page > 1" class="flex justify-center gap-2 mt-6">
                <button
                    v-for="pageNum in pagination.last_page"
                    :key="pageNum"
                    @click="loadReviews(pageNum)"
                    class="px-4 py-2 rounded-md transition-colors"
                    :class="[
                        pageNum === pagination.current_page
                            ? 'bg-blue-600 text-white'
                            : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600'
                    ]"
                >
                    {{ pageNum }}
                </button>
            </div>
        </div>

        <!-- No Reviews -->
        <div v-else-if="!isLoading" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
            <p class="text-gray-600 dark:text-gray-400 text-lg mb-4">
                ยังไม่มีรีวิวสำหรับสถานที่นี้
            </p>
            <p class="text-gray-500 dark:text-gray-500">
                เป็นคนแรกที่เขียนรีวิวและแชร์ประสบการณ์ของคุณ!
            </p>
        </div>

        <!-- Loading -->
        <div v-if="isLoading" class="flex justify-center py-12">
            <svg class="animate-spin h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
</template>
