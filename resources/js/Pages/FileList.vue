<template>
    <div class="flex">
        <div class="p-6 bg-white">
            <h1 class="text-2xl font-bold mb-4">Not imported files</h1>
            <ul class="list-disc pl-5 space-y-2">
                <li v-for="file in files" :key="file" class="text-gray-700">
                    {{ file }}
                </li>
            </ul>
        </div>

        <div class="p-6 bg-white">
            <h1 class="text-2xl font-bold mb-4">Imported files</h1>
            <ul class="list-disc pl-5 space-y-2">
                <li
                    v-for="file in archivedFiles"
                    :key="file"
                    class="text-gray-700"
                >
                    {{ file }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
let props = defineProps({
    files: Object,
    archivedFiles: Object,
});
</script>
