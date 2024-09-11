<template>
    <div>
      <h1>{{ product.description }}</h1>
      <p>Price: {{ product.price }}</p>
 
      <h2>Ratings</h2>
      <p>Avarage rating {{ avg_rating }}</p>
      <ul>
        <li v-for="rating in ratings" :key="rating.id">
          <p>Rating: {{ rating.rating }}</p>
          <p>Comment: {{ rating.comment }}</p>
          <p>User ID: {{ rating.user_id }}</p>
          <button @click="deleteRating(rating.id)">Delete Rating</button>
        </li>
      </ul>
  
      <form v-if="!hasUserRated" @submit.prevent="submitRating">
      <div>
        <label for="rating">Rating:</label>
        <input type="number" v-model="form.rating" min="1" max="6" required>
      </div>
      <div>
        <label for="comment">Comment:</label>
        <textarea v-model="form.comment"></textarea>
      </div>
      <button type="submit">Submit Rating</button>
    </form>
    {{ hasUserRated }}
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  import { router } from '@inertiajs/vue3';
  import { defineProps } from 'vue';
  import NavigationLayout from "@/Layouts/NavigationLayout.vue";

defineOptions({
    layout: NavigationLayout,
}); 
  const props = defineProps({
    product: Object,
    ratings: Array,
    auth: Object,
    avg_rating: Number
  });
  
  const form = ref({
    rating: 1,
    comment: '',
  });
  


  const user = computed(() => props.auth.user);

  const userId = user.value.id
  const hasUserRated = computed(()=>{
    return props.ratings.some((rating) => rating.user_id === userId);
  });
  
console.log(hasUserRated);
  const submitRating = () => {

    router.post(`/products/${props.product.id}/ratings`, form.value)

  };
  
  const deleteRating = (ratingId) => {
    router.delete(`/ratings/${ratingId}`)
  };
  </script>    