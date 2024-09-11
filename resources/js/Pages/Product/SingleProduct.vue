<template>
    <div class="container mx-auto main-layout-padding">




        <h1 class="headline py-4">{{product.description}}</h1>
        <p class="text-xl  mb-2">
          Price: {{ product.price }} {{ product.currency }}
        </p>
        <span class="text-xl  mb-2">Average Rating: </span>
        <span class="text-xl">{{ displayAvgRating }}</span>
  
        <div class="mt-4">

      <!-- <div class="main-layout-padding bg-white rounded-xl shadow-md p-6"> -->
          <h2 class="text-xl font-bold mt-6 mb-4">Ratings</h2>
          <section class="space-y-4">
            <article
              v-for="rating in ratings"
              :key="rating.id"
              class="bg-white p-4 custom-border space-y-2"
            > 

              <h3 class="text-xl">{{ rating.title }}</h3>
              <StarRating :rating="rating.rating" />
              <p class="text-gray-700 font-semibold">Review:</p><span> {{ rating.comment }}</span>
              <div v-if="rating.user_id === userId">
                <button
                  @click="deleteRating(rating.id)"
                  class="text-red-500 hover:text-red-700"
                >
                  Delete Rating
                </button>
              </div>

            </article>
          </section>
  
          <form
            v-if="!hasUserRated"
            @submit.prevent="submitRating"
            class="mt-6 bg-white p-4 custom-border"
          >
            <div class="mb-4">
              <label for="rating" class="standart-label"
                >Rating:</label
              >
              <StarRating :rating="form.rating" @update:rating="setRating" />
            </div>
            <div class="mb-4">
              <label for="title" class="standart-label"
                >Title:</label
              >
              <input
                type="text"
                v-model="form.title"
                required
              class="standart-input"/>
            </div>
            <div class="mb-4">
              <label for="comment" class="standart-label"
                >Comment:</label
              >
              <textarea
                v-model="form.comment"
              class="standart-input"></textarea>
            </div>
            <PrimaryButton>Submit Rating</PrimaryButton>
          </form>
        </div>
      </div>
    <!-- </div> -->
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
