<template>
  <Head title="Log In" />

  <main class="grid place-items-center h-screen -m-20">
    <section class="bg-white p-8 rounded-xl max-w-md mx-auto border w-full">
      <h1 class="text-3xl mb-6">Log In</h1>

      <form @submit.prevent="submit" method="POST">
        <div class="mb-6">
          <label class="standart-label" for="email"> Email </label>

          <input v-model="form.email" class="standart-input" type="email" name="email" id="email" required />

          <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-1"></div>
        </div>

        <div class="mb-6">
          <label class="standart-label" for="password"> Password </label>

          <input
            v-model="form.password"
            class="standart-input"
            type="password"
            name="password"
            id="password"
          />

          <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-1"></div>
        </div>

        <div>
          <button
            type="submit"
            class="black-button"
            :disabled="form.processing"
          >
            Log In
          </button>
        </div>
      </form>
    </section>  
  </main>
</template>


<script setup>
import { useForm, Head } from "@inertiajs/vue3";
import NavigationLayout from "@/Layouts/NavigationLayout.vue";

defineOptions({
  layout: NavigationLayout,
});

let form = useForm({
  name: '',
  email: '',
  password: '',
});

let submit = () => {
  form.post('/login');
};
</script>