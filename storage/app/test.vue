<template>
    <Head :title="pageTitle" />

    <div class="container mx-auto main-layout-padding">
        <h1 class="headline py-4">{{ product.description }}</h1>
        <p class="text-xl mb-2">
            Price: {{ product.price }} {{ product.currency }}
        </p>
        <span class="text-xl mb-2">Average Rating: </span>
        <span class="text-xl">{{ displayAvgRating }}</span>

        <div class="mt-4">
            <h2 class="text-xl font-bold mt-6 mb-4">Ratings</h2>
            <section class="space-y-4">
                <article
                    v-for="rating in ratings"
                    :key="rating.id"
                    v-show="editingRatingId !== rating.id"
                    class="bg-white p-4 custom-border space-y-2"
                >
                    <h3 class="text-xl">{{ rating.title }}</h3>
                    <StarRating :rating="rating.rating" />
                    <p class="text-gray-700 font-semibold">Review:</p>
                    <span> {{ rating.comment }}</span>
                    <div class="space-x-3" v-if="rating.user_id === userId">
                        <button
                            @click="deleteRating(rating.id)"
                            class="black-button"
                        >
                            Delete Rating
                        </button>
                        <button
                            @click="editRating(rating)"
                            class="black-button"
                        >
                            Edit Rating
                        </button>
                    </div>
                </article>
            </section>
            <div>
                <div v-if="!hasUserRated">
                    <RatingForm
                        :form="form"
                        :isEditing="isEditing"
                        :productId="product.id"
                        @submit="submitRating"
                    />
                </div>
                <div v-if="isSubmitting">
                    <RatingForm
                        :form="form"
                        :isEditing="isEditing"
                        :productId="product.id"
                        @submit="submitEditRating"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { router, Head } from "@inertiajs/vue3";
import { defineProps } from "vue";
import NavigationLayout from "@/Layouts/NavigationLayout.vue";
import StarRating from "@/Components/Rating/StarRating.vue";
import RatingForm from "@/Components/Rating/RatingForm.vue";

defineOptions({
    layout: NavigationLayout,
});

const props = defineProps({
    product: Object,
    ratings: Array,
    auth: Object,
    avg_rating: Number,
});

const displayAvgRating = computed(() => {
    return props.avg_rating !== null && props.avg_rating !== undefined
        ? props.avg_rating
        : "Rating not set";
});

const pageTitle = computed(() => {
    return props.product.description
        ? `Product: ${props.product.description}`
        : "Product Details";
});

const form = ref({
    rating: 1,
    title: "",
    comment: "",
});

const user = computed(() => props.auth.user);
const userId = computed(() => user.value.id);
const isEditing = ref(false);
const isSubmitting = ref(false);
const editingRatingId<template>
    <Head :title="pageTitle" />

    <div class="container mx-auto main-layout-padding">
        <h1 class="headline py-4">{{ product.description }}</h1>
        <p class="text-xl mb-2">
            Price: {{ product.price }} {{ product.currency }}
        </p>
        <span class="text-xl mb-2">Average Rating: </span>
        <span class="text-xl">{{ displayAvgRating }}</span>

        <div class="mt-4">
            <h2 class="text-xl font-bold mt-6 mb-4">Ratings</h2>
            <section class="space-y-4">
                <article
                    v-for="rating in ratings"
                    :key="rating.id"
                    v-show="editingRatingId !== rating.id"
                    class="bg-white p-4 custom-border space-y-2"
                >
                    <h3 class="text-xl">{{ rating.title }}</h3>
                    <StarRating :rating="rating.rating" />
                    <p class="text-gray-700 font-semibold">Review:</p>
                    <span> {{ rating.comment }}</span>
                    <div class="space-x-3" v-if="rating.user_id === userId">
                        <button
                            @click="deleteRating(rating.id)"
                            class="black-button"
                        >
                            Delete Rating
                        </button>
                        <button
                            @click="editRating(rating)"
                            class="black-button"
                        >
                            Edit Rating
                        </button>
                    </div>
                </article>
            </section>
            <div>
                <div v-if="!hasUserRated">
                    <RatingForm
                        :form="form"
                        :isEditing="isEditing"
                        :productId="product.id"
                        @submit="submitRating"
                    />
                </div>
                <div v-if="isSubmitting">
                    <RatingForm
                        :form="form"
                        :isEditing="isEditing"
                        :productId="product.id"
                        @submit="submitEditRating"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { router, Head } from "@inertiajs/vue3";
import { defineProps } from "vue";
import NavigationLayout from "@/Layouts/NavigationLayout.vue";
import StarRating from "@/Components/Rating/StarRating.vue";
import RatingForm from "@/Components/Rating/RatingForm.vue";

defineOptions({
    layout: NavigationLayout,
});

const props = defineProps({
    product: Object,
    ratings: Array,
    auth: Object,
    avg_rating: Number,
});

const displayAvgRating = computed(() => {
    return props.avg_rating !== null && props.avg_rating !== undefined
        ? props.avg_rating
        : "Rating not set";
});

const pageTitle = computed(() => {
    return props.product.description
        ? `Product: ${props.product.description}`
        : "Product Details";
});

const form = ref({
    rating: 1,
    title: "",
    comment: "",
});

const user = computed(() => props.auth.user);
const userId = computed(() => user.value.id);
const isEditing = ref(false);
const isSubmitting = ref(false);
const editingRatingId = ref(null);
const hasUserRated = computed(() => {
    return props.ratings.some((rating) => rating.user_id === userId.value);
});

const submitRating = () => {
    router.put(`/ratings/${form.value.id}`, form.value).then(() => {
        isEditing.value = false;
        editingRatingId.value = null;
    });
};

const submitEditRating = () => 
    router.post(`/products/${props.product.id}/ratings`, form.value)
    .then(() => {
        isEditing.value = false;
        editingRatingId.value = null;

    });

const deleteRating = (ratingId) => {
    router.delete(`/ratings/${ratingId}`)
};

const editRating = (rating) => {
    isEditing.value = true;
    editingRatingId.value = rating.id;
    form.value.rating = rating.rating;
    form.value.title = rating.title;
    form.value.comment = rating.comment;
    form.value.id = rating.id;
};
</script>
omputed(() => {
    return props.ratings.some((rating) => rating.user_id === userId.value);
});

const submitRating = () => {
    router.put(`/ratings/${form.value.id}`, form.value).then(() => {
        isEditing.value = false;
        editingRatingId.value = null;
    });
};

const submitEditRating = () => 
    router.post(`/products/${props.product.id}/ratings`, form.value)
    .then(() => {
        isEditing.value = false;
        editingRatingId.value = null;

    });

const deleteRating = (ratingId) => {
    router.delete(`/ratings/${ratingId}`)
};

const editRating = (rating) => {
    isEditing.value = true;
    editingRatingId.value = rating.id;
    form.value.rating = rating.rating;
    form.value.title = rating.title;
    form.value.comment = rating.comment;
    form.value.id = rating.id;
};
</script>
