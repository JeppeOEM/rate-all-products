<template>
    <Link
      class="text-black hover:underline"
      :class="{ 'font-bold underline': active }"
    >
      <slot />
    </Link>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3';
  const props = defineProps({
    active: Boolean
  });
  </script>