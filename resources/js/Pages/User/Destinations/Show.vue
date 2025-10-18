<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import CommentItem from "@/Components/User/CommentItem.vue";
import { Button, Textarea } from "primevue";
import { ref, computed } from "vue";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    destination: {
        type: Object,
        required: true,
    },
    comments: {
        type: Array,
        default: () => [],
    },
});

const isLiked = ref(props.destination.is_liked || false);
const likeCount = ref(props.destination.like_count || 0);
const isTogglingLike = ref(false);
const replyingTo = ref(null);

const commentForm = useForm({
    content: "",
});

const priceRange = computed(() => {
    if (!props.destination.price_from && !props.destination.price_to) {
        return "ฟรี";
    }
    if (props.destination.price_from && props.destination.price_to) {
        if (props.destination.price_from === props.destination.price_to) {
            return `${Number(props.destination.price_from).toLocaleString()} บาท`;
        }
        return `${Number(props.destination.price_from).toLocaleString()} - ${Number(props.destination.price_to).toLocaleString()} บาท`;
    }
    if (props.destination.price_from) {
        return `เริ่มต้น ${Number(props.destination.price_from).toLocaleString()} บาท`;
    }
    return `สูงสุด ${Number(props.destination.price_to).toLocaleString()} บาท`;
});

const toggleLike = async () => {
    if (isTogglingLike.value) return;

    isTogglingLike.value = true;
    const previousLiked = isLiked.value;
    const previousCount = likeCount.value;

    isLiked.value = !isLiked.value;
    likeCount.value = isLiked.value ? likeCount.value + 1 : likeCount.value - 1;

    try {
        router.post(
            route("destinations.like.toggle", props.destination.id),
            {},
            {
                preserveScroll: true,
                onError: () => {
                    isLiked.value = previousLiked;
                    likeCount.value = previousCount;
                },
                onFinish: () => {
                    isTogglingLike.value = false;
                },
            }
        );
    } catch (error) {
        isLiked.value = previousLiked;
        likeCount.value = previousCount;
        isTogglingLike.value = false;
    }
};

const submitComment = () => {
    const url = replyingTo.value
        ? route("destinations.comments.store", props.destination.id)
        : route("destinations.comments.store", props.destination.id);

    const data = replyingTo.value
        ? { content: commentForm.content, parent_id: replyingTo.value.id }
        : { content: commentForm.content };

    commentForm.post(url, {
        data,
        preserveScroll: true,
        onSuccess: () => {
            commentForm.reset();
            replyingTo.value = null;
        },
    });
};

const handleReply = (comment) => {
    replyingTo.value = comment;
    // Scroll to comment form
    document.getElementById("comment-form")?.scrollIntoView({ behavior: "smooth" });
};

const cancelReply = () => {
    replyingTo.value = null;
};
</script>

<template>
    <UserLayout :title="destination.name">
        <!-- Hero Image -->
        <div class="relative h-[50vh] md:h-[60vh] bg-gray-900">
            <img
                :src="destination.cover_image || '/images/placeholder.jpg'"
                :alt="destination.name"
                class="w-full h-full object-cover"
            />
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"
            ></div>

            <!-- Floating Action Button -->
            <div class="absolute top-4 right-4">
                <Button
                    @click="toggleLike"
                    :disabled="isTogglingLike"
                    rounded
                    :severity="isLiked ? 'danger' : 'secondary'"
                    class="backdrop-blur-sm"
                    :class="{
                        'bg-white/90': !isLiked,
                    }"
                >
                    <i
                        :class="
                            isLiked ? 'pi pi-heart-fill text-red-500' : 'pi pi-heart'
                        "
                    ></i>
                </Button>
            </div>

            <!-- Title Overlay -->
            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 text-white">
                <div class="max-w-7xl mx-auto">
                    <div class="flex items-center gap-2 mb-2">
                        <span
                            class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm"
                        >
                            {{ destination.category?.name || "ทั่วไป" }}
                        </span>
                        <span
                            v-if="destination.is_featured"
                            class="px-3 py-1 bg-yellow-500/90 rounded-full text-sm font-semibold"
                        >
                            <i class="pi pi-star-fill"></i> แนะนำ
                        </span>
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2">
                        {{ destination.name }}
                    </h1>
                    <p class="text-lg opacity-90 flex items-center gap-2">
                        <i class="pi pi-map-marker"></i>
                        {{ destination.province?.name_th || "ไม่ระบุจังหวัด" }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Description -->
                    <div
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                    >
                        <h2 class="text-2xl font-bold mb-4">รายละเอียด</h2>
                        <div
                            v-if="destination.short_description"
                            class="text-lg opacity-80 mb-4"
                        >
                            {{ destination.short_description }}
                        </div>
                        <div
                            v-if="destination.description"
                            class="prose dark:prose-invert max-w-none"
                        >
                            {{ destination.description }}
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div
                        id="comments-section"
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6"
                    >
                        <h2 class="text-2xl font-bold mb-6">
                            ความคิดเห็น ({{ comments.length }})
                        </h2>

                        <!-- Comment Form -->
                        <div id="comment-form" class="mb-6">
                            <div v-if="replyingTo" class="mb-3 p-3 bg-blue-500/10 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm">
                                        <i class="pi pi-reply"></i>
                                        ตอบกลับ <strong>{{ replyingTo.user?.name }}</strong>
                                    </span>
                                    <Button
                                        @click="cancelReply"
                                        icon="pi pi-times"
                                        text
                                        rounded
                                        size="small"
                                    />
                                </div>
                            </div>

                            <form @submit.prevent="submitComment">
                                <Textarea
                                    v-model="commentForm.content"
                                    rows="3"
                                    placeholder="แบ่งปันความคิดเห็นของคุณ..."
                                    class="w-full mb-3"
                                    autoResize
                                />
                                <div class="flex justify-end">
                                    <Button
                                        type="submit"
                                        label="โพสต์ความคิดเห็น"
                                        icon="pi pi-send"
                                        :loading="commentForm.processing"
                                        :disabled="
                                            !commentForm.content || commentForm.processing
                                        "
                                    />
                                </div>
                            </form>
                        </div>

                        <!-- Comments List -->
                        <div v-if="comments.length > 0" class="space-y-6">
                            <CommentItem
                                v-for="comment in comments"
                                :key="comment.id"
                                :comment="comment"
                                :destination-id="destination.id"
                                @reply="handleReply"
                            />
                        </div>
                        <div v-else class="text-center py-8 opacity-70">
                            <i class="pi pi-comments text-4xl mb-3"></i>
                            <p>ยังไม่มีความคิดเห็น เป็นคนแรกที่แสดงความคิดเห็น!</p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Info Card -->
                    <div
                        class="bg-[var(--p-content-background)] rounded-xl border border-surface-300 dark:border-surface-700 p-6 sticky top-4"
                    >
                        <h3 class="text-xl font-bold mb-4">ข้อมูลสถานที่</h3>

                        <!-- Price -->
                        <div class="mb-4 pb-4 border-b border-surface-300 dark:border-surface-700">
                            <div class="text-sm opacity-70 mb-1">ค่าใช้จ่าย</div>
                            <div class="text-2xl font-bold text-[var(--p-primary-color)]">
                                {{ priceRange }}
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm opacity-70">
                                    <i class="pi pi-eye"></i> ยอดดู
                                </span>
                                <span class="font-semibold">
                                    {{ (destination.view_count || 0).toLocaleString() }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm opacity-70">
                                    <i class="pi pi-heart"></i> ถูกใจ
                                </span>
                                <span class="font-semibold">
                                    {{ likeCount.toLocaleString() }}
                                </span>
                            </div>
                            <div
                                v-if="destination.average_rating"
                                class="flex items-center justify-between"
                            >
                                <span class="text-sm opacity-70">
                                    <i class="pi pi-star-fill text-yellow-500"></i> คะแนน
                                </span>
                                <span class="font-semibold">
                                    {{ Number(destination.average_rating).toFixed(1) }}
                                    <span class="text-sm opacity-60">
                                        ({{ destination.total_reviews || 0 }})
                                    </span>
                                </span>
                            </div>
                        </div>

                        <!-- Features -->
                        <div
                            v-if="
                                destination.has_parking ||
                                destination.has_wifi ||
                                destination.has_restaurant ||
                                destination.pet_friendly
                            "
                            class="pt-4 border-t border-surface-300 dark:border-surface-700"
                        >
                            <div class="text-sm font-semibold mb-3">สิ่งอำนวยความสะดวก</div>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    v-if="destination.has_parking"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-full text-xs"
                                >
                                    <i class="pi pi-car"></i> ที่จอดรถ
                                </span>
                                <span
                                    v-if="destination.has_wifi"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-500/10 text-green-600 dark:text-green-400 rounded-full text-xs"
                                >
                                    <i class="pi pi-wifi"></i> WiFi
                                </span>
                                <span
                                    v-if="destination.has_restaurant"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-orange-500/10 text-orange-600 dark:text-orange-400 rounded-full text-xs"
                                >
                                    <i class="pi pi-shopping-bag"></i> ร้านอาหาร
                                </span>
                                <span
                                    v-if="destination.pet_friendly"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-pink-500/10 text-pink-600 dark:text-pink-400 rounded-full text-xs"
                                >
                                    <i class="pi pi-heart"></i> สัตว์เลี้ยงเข้าได้
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
