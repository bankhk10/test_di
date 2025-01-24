<template>
    <div class="flex justify-center mt-6 space-x-4">
      <button
        @click="prevPage"
        :disabled="currentPage === 1"
        class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 disabled:opacity-50"
      >
        Previous
      </button>
      <span class="text-gray-300">
        Page {{ currentPage }} of {{ totalPages }}
      </span>
      <button
        @click="nextPage"
        :disabled="currentPage >= totalPages"
        class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 disabled:opacity-50"
      >
        Next
      </button>
    </div>
  </template>

  <script setup>
  defineProps({
    currentPage: Number,
    totalPages: Number
  });

  const emit = defineEmits(['prevPage', 'nextPage']);

  const prevPage = () => emit('prevPage');
  const nextPage = () => emit('nextPage');
  </script>
