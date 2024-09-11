<template>
  <Head title="Create User" />

  <main class="grid place-items-center h-screen -m-10">
    <section class="bg-white p-8 rounded-lg max-w-md mx-auto border w-full">
      <h1 class="text-3xl mb-6">Create New User</h1>

      <form @submit.prevent="submit" method="POST">
        <div class="mb-6">
          <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="name"> Name </label>
          <input v-model="form.name" class="border p-2 w-full rounded" type="text" name="name" id="name" required />
          <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-xs mt-1"></div>
        </div>

        <div class="mb-6">
          <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="email"> Email </label>
          <input v-model="form.email" class="border p-2 w-full rounded" type="email" name="email" id="email" required />
          <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-1"></div>
        </div>

        <div class="mb-6">
          <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="password"> Password </label>
          <input v-model="form.password" class="border p-2 w-full rounded" type="password" name="password" id="password" />
          <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-1"></div>
        </div>

        <div>
          <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500" :disabled="form.processing">
            Submit
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
    errors: Object,
});

  let form = useForm({
    name: '',
    email: '',
    password: '',
  });
  
  let submit = () => {
    form.post('/users');
  };
  </script>