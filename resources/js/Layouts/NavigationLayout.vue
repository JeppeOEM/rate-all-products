<template>
    <Head>
      <!-- fallback title -->
      <title>Product ratings</title>
    </Head>
      <section class="p-6 bg-gray-200">
        <header class="flex justify-between">
          <p>{{ name }}</p>
          <div class="flex items-center">
            <nav>
              <Link href="/">Home</Link>
              <Link href="/auth/login">Login</Link>
              <Link href="/auth/logout">Logout</Link>
              <Link href="/auth/create">Register</Link>
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
    // import Nav from '../Components/Nav.vue';
    import { Head, Link, usePage } from '@inertiajs/vue3';
    
    const page = usePage();
    const name = computed(() => page.props.auth.user.name);
    </script>
