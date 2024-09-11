<template>
    <form
        @submit.prevent="handleSubmit"
        class="mt-6 bg-white p-4 custom-border"
    >
        <div class="mb-4">
            <label for="rating" class="standart-label">Rating:</label>
            <StarRating :rating="form.rating" @update:rating="setRating" />
        </div>
        <div class="mb-4">
            <label for="title" class="standart-label">Title:</label>
            <input
                type="text"
                v-model="form.title"
                required
                class="standart-input"
            />
        </div>
        <div class="mb-4">
            <label for="comment" class="standart-label">Comment:</label>
            <textarea v-model="form.comment" class="standart-input"></textarea>
        </div>
        <PrimaryButton>{{ isEditing ? 'Update Rating' : 'Submit Rating' }}</PrimaryButton>
    </form>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';
import StarRating from '@/Components/Rating/StarRating.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';

const props = defineProps({
    form: Object,
    isEditing: Boolean,
    productId: Number,
});

const emit = defineEmits(['submit']);

const setRating = (star) => {
    props.form.rating = star;
};

const handleSubmit = () => {
    emit('submit');
};
</script>