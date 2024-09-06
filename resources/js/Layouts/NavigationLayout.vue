<template>
    <Head>
      <!-- fallback title -->
      <title>Product ratings</title>
    </Head>
      <section class="p-6 bg-gray-200">
        <header class="flex justify-between">
          <p v-if="user" class="mr-4">
        You are logged in as: {{ user.name }}
      </p>
          <div class="flex items-center">
            <nav>
              <NavLink v-if="user" href="/logout" method="post" as="button">
                Logout
              </NavLink>
              <NavLink v-if="user" href="/" :active="$page.component === 'Home'">
                Home
              </NavLink>
              <NavLink v-if="!user" href="/auth/create" :active="$page.component === 'Auth/Create'">
                Register
              </NavLink>
              <NavLink v-if="!user" href="/auth/login" :active="$page.component === 'Auth/Login'">
                Login
              </NavLink>
            </nav>
          </div>
    
          <!-- <Nav /> -->
        </header>
      </section>
    
      <section class="p-6">
        <div class="max-w-3xl mx-auto">
          <slot />
        </div>
      </section>
    </template>
    
    <script setup>
    import { computed } from 'vue';
    import NavLink from '../Components/NavLink.vue';
    import { Head, usePage } from '@inertiajs/vue3';

const props = defineProps({
  auth: {
    type: Object,
    required: true
  }
});


const user = computed(() => props.auth.user);
    </script>
