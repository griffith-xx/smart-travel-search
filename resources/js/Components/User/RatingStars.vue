<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Number,
        default: 0,
    },
    max: {
        type: Number,
        default: 5,
    },
    readonly: {
        type: Boolean,
        default: false,
    },
    size: {
        type: String,
        default: 'md', // sm, md, lg
    },
    showText: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue']);

const hoverRating = ref(0);

const sizeClasses = computed(() => {
    const sizes = {
        sm: 'w-4 h-4',
        md: 'w-6 h-6',
        lg: 'w-8 h-8',
    };
    return sizes[props.size] || sizes.md;
});

const ratingText = computed(() => {
    const texts = {
        1: 'แย่มาก',
        2: 'แย่',
        3: 'ปานกลาง',
        4: 'ดี',
        5: 'ดีเยี่ยม',
    };
    return texts[Math.floor(props.modelValue)] || '';
});

const setRating = (rating) => {
    if (!props.readonly) {
        emit('update:modelValue', rating);
    }
};

const handleMouseEnter = (rating) => {
    if (!props.readonly) {
        hoverRating.value = rating;
    }
};

const handleMouseLeave = () => {
    if (!props.readonly) {
        hoverRating.value = 0;
    }
};

const isFilled = (index) => {
    const currentRating = hoverRating.value || props.modelValue;
    return index <= currentRating;
};

const isHalfFilled = (index) => {
    if (hoverRating.value > 0) {
        return false;
    }
    const decimal = props.modelValue - Math.floor(props.modelValue);
    return index === Math.ceil(props.modelValue) && decimal >= 0.3 && decimal < 0.8;
};
</script>

<template>
    <div class="flex items-center gap-1">
        <div class="flex items-center gap-0.5">
            <button
                v-for="index in max"
                :key="index"
                type="button"
                class="relative transition-transform"
                :class="[
                    sizeClasses,
                    !readonly && 'hover:scale-110 cursor-pointer',
                    readonly && 'cursor-default',
                ]"
                @click="setRating(index)"
                @mouseenter="handleMouseEnter(index)"
                @mouseleave="handleMouseLeave"
                :disabled="readonly"
            >
                <!-- Full star -->
                <svg
                    v-if="isFilled(index)"
                    class="text-yellow-400 dark:text-yellow-500"
                    :class="sizeClasses"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                </svg>

                <!-- Half star -->
                <svg
                    v-else-if="isHalfFilled(index)"
                    class="text-yellow-400 dark:text-yellow-500"
                    :class="sizeClasses"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <defs>
                        <linearGradient :id="`half-${index}`">
                            <stop offset="50%" stop-color="currentColor" />
                            <stop offset="50%" stop-color="transparent" />
                        </linearGradient>
                    </defs>
                    <path
                        :fill="`url(#half-${index})`"
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                    <path
                        class="text-gray-300 dark:text-gray-600"
                        fill="currentColor"
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                </svg>

                <!-- Empty star -->
                <svg
                    v-else
                    class="text-gray-300 dark:text-gray-600"
                    :class="sizeClasses"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                </svg>
            </button>
        </div>

        <span
            v-if="showText"
            class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300"
        >
            {{ modelValue > 0 ? `${modelValue.toFixed(1)} ${ratingText}` : 'ยังไม่มีคะแนน' }}
        </span>
    </div>
</template>
