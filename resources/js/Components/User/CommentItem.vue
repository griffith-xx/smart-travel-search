<script setup>
import { Button, Textarea } from "primevue";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    comment: {
        type: Object,
        required: true,
    },
    destinationId: {
        type: Number,
        required: true,
    },
    isReply: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["reply"]);

const isLiked = ref(props.comment.is_liked || false);
const likeCount = ref(props.comment.likes_count || 0);
const isTogglingLike = ref(false);
const isEditing = ref(false);
const editContent = ref(props.comment.content);
const showReplies = ref(true);
const isSavingEdit = ref(false);
const editError = ref("");
const isDeleting = ref(false);

const userInitials = computed(() => {
    const name = props.comment.user?.name || "";
    const words = name.trim().split(/\s+/);
    if (words.length >= 2) {
        return (words[0][0] + words[1][0]).toUpperCase();
    }
    return name.substring(0, 2).toUpperCase();
});

const formattedDate = computed(() => {
    const date = new Date(props.comment.created_at);
    const now = new Date();
    const diff = now - date;
    const minutes = Math.floor(diff / 60000);
    const hours = Math.floor(diff / 3600000);
    const days = Math.floor(diff / 86400000);

    if (minutes < 1) return "เมื่อสักครู่";
    if (minutes < 60) return `${minutes} นาทีที่แล้ว`;
    if (hours < 24) return `${hours} ชั่วโมงที่แล้ว`;
    if (days < 7) return `${days} วันที่แล้ว`;

    return date.toLocaleDateString("th-TH", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
});

const toggleLike = async () => {
    if (isTogglingLike.value) return;

    isTogglingLike.value = true;
    const previousLiked = isLiked.value;
    const previousCount = likeCount.value;

    isLiked.value = !isLiked.value;
    likeCount.value = isLiked.value ? likeCount.value + 1 : likeCount.value - 1;

    try {
        await axios.post(route("comments.like.toggle", props.comment.id));
    } catch (error) {
        isLiked.value = previousLiked;
        likeCount.value = previousCount;
        console.error("Error toggling comment like:", error);
    } finally {
        isTogglingLike.value = false;
    }
};

const handleReply = () => {
    emit("reply", props.comment);
};

const saveEdit = async () => {
    if (!editContent.value.trim() || isSavingEdit.value) {
        return;
    }

    isSavingEdit.value = true;
    editError.value = "";

    try {
        await axios.put(route("comments.update", props.comment.id), {
            content: editContent.value.trim(),
        });

        // Reload page to show updated comment
        router.reload({ preserveScroll: true });
        isEditing.value = false;
    } catch (error) {
        if (error.response?.data?.errors?.content) {
            editError.value = error.response.data.errors.content[0];
        } else if (error.response?.data?.message) {
            editError.value = error.response.data.message;
        } else {
            editError.value = "เกิดข้อผิดพลาดในการแก้ไขความคิดเห็น";
        }
    } finally {
        isSavingEdit.value = false;
    }
};

const cancelEdit = () => {
    editContent.value = props.comment.content;
    editError.value = "";
    isEditing.value = false;
};

const deleteComment = async () => {
    if (!confirm("คุณต้องการลบความคิดเห็นนี้หรือไม่?")) {
        return;
    }

    if (isDeleting.value) {
        return;
    }

    isDeleting.value = true;

    try {
        await axios.delete(route("comments.destroy", props.comment.id));

        // Reload page to show updated comments
        router.reload({ preserveScroll: true });
    } catch (error) {
        alert(
            error.response?.data?.message ||
                "เกิดข้อผิดพลาดในการลบความคิดเห็น"
        );
    } finally {
        isDeleting.value = false;
    }
};
</script>

<template>
    <div class="flex gap-3">
        <!-- Avatar -->
        <div
            class="flex-shrink-0 w-10 h-10 rounded-full bg-[var(--p-primary-color)] text-white flex items-center justify-center text-sm font-semibold"
        >
            {{ userInitials }}
        </div>

        <!-- Content -->
        <div class="flex-1 min-w-0">
            <!-- Header -->
            <div class="flex items-center gap-2 mb-1">
                <span class="font-semibold text-sm">{{
                    comment.user?.name
                }}</span>
                <span class="text-xs opacity-60">{{ formattedDate }}</span>
                <span
                    v-if="comment.is_edited"
                    class="text-xs opacity-50 italic"
                    >แก้ไขแล้ว</span
                >
            </div>

            <!-- Content or Edit Form -->
            <div v-if="!isEditing" class="mb-2">
                <p class="text-sm whitespace-pre-wrap break-words">
                    {{ comment.content }}
                </p>
            </div>
            <div v-else class="mb-2">
                <Textarea
                    v-model="editContent"
                    rows="3"
                    class="w-full mb-2"
                    autoResize
                    :class="{ 'border-red-500': editError }"
                />
                <div v-if="editError" class="text-red-500 text-sm mb-2">
                    {{ editError }}
                </div>
                <div class="flex gap-2">
                    <Button
                        @click="saveEdit"
                        label="บันทึก"
                        size="small"
                        icon="pi pi-check"
                        :loading="isSavingEdit"
                        :disabled="!editContent.trim() || isSavingEdit"
                    />
                    <Button
                        @click="cancelEdit"
                        label="ยกเลิก"
                        size="small"
                        severity="secondary"
                        outlined
                        icon="pi pi-times"
                        :disabled="isSavingEdit"
                    />
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3 text-xs">
                <button
                    @click="toggleLike"
                    :disabled="isTogglingLike"
                    class="flex items-center gap-1 hover:text-[var(--p-primary-color)] transition"
                    :class="{
                        'text-[var(--p-primary-color)]': isLiked,
                        'opacity-70': !isLiked,
                    }"
                >
                    <i
                        :class="isLiked ? 'pi pi-heart-fill' : 'pi pi-heart'"
                    ></i>
                    <span>{{ likeCount }}</span>
                </button>

                <button
                    v-if="!isReply"
                    @click="handleReply"
                    class="flex items-center gap-1 opacity-70 hover:opacity-100 hover:text-[var(--p-primary-color)] transition"
                >
                    <i class="pi pi-reply"></i>
                    <span>ตอบกลับ</span>
                </button>

                <button
                    v-if="comment.user?.id === $page.props.auth.user?.id"
                    @click="isEditing = !isEditing"
                    class="flex items-center gap-1 opacity-70 hover:opacity-100 hover:text-blue-500 transition"
                >
                    <i class="pi pi-pencil"></i>
                    <span>แก้ไข</span>
                </button>

                <button
                    v-if="comment.user?.id === $page.props.auth.user?.id"
                    @click="deleteComment"
                    :disabled="isDeleting"
                    class="flex items-center gap-1 opacity-70 hover:opacity-100 hover:text-red-500 transition"
                    :class="{ 'cursor-wait opacity-50': isDeleting }"
                >
                    <i :class="isDeleting ? 'pi pi-spin pi-spinner' : 'pi pi-trash'"></i>
                    <span>{{ isDeleting ? 'กำลังลบ...' : 'ลบ' }}</span>
                </button>

                <button
                    v-if="comment.replies && comment.replies.length > 0"
                    @click="showReplies = !showReplies"
                    class="flex items-center gap-1 opacity-70 hover:opacity-100 transition"
                >
                    <i
                        :class="
                            showReplies ? 'pi pi-chevron-up' : 'pi pi-chevron-down'
                        "
                    ></i>
                    <span>{{ comment.replies.length }} ตอบกลับ</span>
                </button>
            </div>

            <!-- Replies -->
            <div
                v-if="
                    comment.replies &&
                    comment.replies.length > 0 &&
                    showReplies
                "
                class="mt-4 space-y-3 pl-4 border-l-2 border-surface-300 dark:border-surface-700"
            >
                <CommentItem
                    v-for="reply in comment.replies"
                    :key="reply.id"
                    :comment="reply"
                    :destination-id="destinationId"
                    :is-reply="true"
                />
            </div>
        </div>
    </div>
</template>
