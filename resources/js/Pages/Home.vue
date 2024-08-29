<template>Hellocccccccccc {{ counter }}!
<input type="file" @change="showFile">


<h1 class="text-3xl font-bold underline">
    Hello world!
  </h1>
</template>
<script setup>
  import {ref} from 'vue'
  const counter = ref(0)
  setInterval(() => counter.value++, 1000)

function showFile(input) {
  let file = input.files[0];

  alert(`File name: ${file.name}`); // e.g my.png
  alert(`Last modified: ${file.lastModified}`); // e.g 1552830408824
}
</script>