<template>
    <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col items-center pb-10 bg-gray-800 rounded-md">
            <img class="w-24 h-24 mb-3 rounded-full shadow-lg mt-8" :src="user.imageCard" :alt="user.name" />
            <h5 class="mb-1 text-xl font-medium text-stone-50 dark:text-white">
                {{ user.name }}
            </h5>
            <span class="text-sm text-gray-400 dark:text-gray-400">
                {{ user.jobTitle }}
            </span>
            <div class="flex mt-4 md:mt-6 space-x-4">
                <a href="/admin/detail"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                    Detail
                </a>
                <a href="#"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-slate-200">
                    Log
                </a>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    user: Object
});
</script>
