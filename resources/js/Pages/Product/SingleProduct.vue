<template>
    <div class="container mx-auto main-layout-padding">
        <h1 class="text-2xl font-bold mb-4">{{ product.description }}</h1>
        <p class="text-lg font-semibold mb-2">
          Price: {{ product.price }} {{ product.currency }}
        </p>
        <span class="text-lg font-semibold mb-2">Average Rating:</span>
        <span>{{ displayAvgRating }}</span>
  
        <div class="mt-4">

      <div class="main-layout-padding bg-white rounded-xl shadow-md p-6">
          <h2 class="text-xl font-bold mt-6 mb-4">Ratings</h2>
          <ul class="space-y-4">
            <li
              v-for="rating in ratings"
              :key="rating.id"
              class="bg-gray-100 p-4 rounded-lg shadow-sm"
            >
              <h3 class="text-xl">{{ rating.title }}</h3>
              <StarRating :rating="rating.rating" />
              <p class="text-gray-700">Review: {{ rating.comment }}</p>
              <div v-if="rating.user_id === userId">
                <button
                  @click="deleteRating(rating.id)"
                  class="text-red-500 hover:text-red-700"
                >
                  Delete Rating
                </button>
              </div>
            </li>
          </ul>
  
          <form
            v-if="!hasUserRated"
            @submit.prevent="submitRating"
            class="mt-6 bg-gray-50 p-4 rounded-lg shadow-md"
          >
            <div class="mb-4">
              <label for="rating" class="block text-sm font-medium text-gray-700"
                >Rating:</label
              >
              <StarRating :rating="form.rating" @update:rating="setRating" />
            </div>
            <div class="mb-4">
              <label for="title" class="block text-sm font-medium text-gray-700"
                >Title:</label
              >
              <input
                type="text"
                v-model="form.title"
                required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              />
            </div>
            <div class="mb-4">
              <label for="comment" class="block text-sm font-medium text-gray-700"
                >Comment:</label
              >
              <textarea
                v-model="form.comment"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              ></textarea>
            </div>
            <PrimaryButton>Submit Rating</PrimaryButton>
          </form>
        </div>
      </div>
    </div>
  </template>

<script setup>
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { defineProps } from "vue";
import NavigationLayout from     "@/Layouts/NavigationLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import StarRating from "@/Components/StarRating.vue";

defineOptions({
  layout: NavigationLayout,
});

const props = defineProps({
  product: Object,
  ratings: Array,
  auth: Object,
  avg_rating: Number 
  });

  const displayAvgRating = computed(() => {
  return props.avg_rating !== null && props.avg_rating !== undefined ? props.avg_rating : "Rating not set";
});
const form = ref({
  rating: 1,
  title: "",
  comment: "",
});

const setRating = (star) => {
form.value.rating = star;
};

const user = computed(() => props.auth.user);
const userId = computed(() => user.value.id);

const hasUserRated = computed(() => {
  return props.ratings.some((rating) => rating.user_id === userId.value);
});

const submitRating = () => {
  router
      .post(`/products/${props.product.id}/ratings`, form.value)
      .then(() => {
          form.value.rating = 1;
          form.value.title = "";
          form.value.comment = "";
      });
};

const deleteRating = (ratingId) => {
  router.delete(`/ratings/${ratingId}`);
};
</script>
