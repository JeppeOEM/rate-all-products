<template>
    <div class="flex space-x-1">
        <span
            v-for="star in 5"
            :key="star"
            class="cursor-pointer"
            @click="setRating(star)"
        >
            <svg
                :class="{
                    'text-yellow-500': star <= rating,
                    'text-gray-300': star > rating,
                }"
                class="w-6 h-6"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.36 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z"
                />
            </svg>
        </span>
    </div>
</template>

<script setup>
import { defineEmits } from "vue";

const props = defineProps({
    rating: {
        type: Number,
        required: true,
    },
});

const emits = defineEmits(["update:rating"]);

const setRating = (star) => {
    emits("update:rating", star);
};
</script>
