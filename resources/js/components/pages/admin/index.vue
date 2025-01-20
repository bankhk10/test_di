<script setup>
const imageCard = "/img/logoVbeyond-bg.png";


</script>

<template>
    <Header />
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="font-serif text-3xl tracking-tight text-sky-900 text-center">
                ข้อมูลพนักงาน
            </h1>
        </div>
    </header>
    <main>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 py-6">
            <div v-for="user in users" :key="user.name"
                class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-col items-center pb-10 bg-gray-800 rounded-md">
                    <img class="w-24 h-24 mb-3 rounded-full shadow-lg mt-8" :src="user.imageCard" :alt="user.name" />
                    <h5 class="mb-1 text-xl font-medium text-stone-50 dark:text-white">
                        {{ user.name }}
                    </h5>
                    <span class="text-sm text-gray-400 dark:text-gray-400">
                        {{ user.jobTitle }}
                    </span>
                    <div class="flex mt-4 md:mt-6">
                        <a href="/admin/detail"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Detail
                        </a>
                        <a href="#"
                            class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 focus:z-10 focus:ring-4  hover:bg-slate-200">
                            Log
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="text-center mt-4">
    <v-pagination
      v-model="page"
      :length="45"
      :total-visible="7"
    ></v-pagination>
  </div>
</template>

<script>
import Header from '../../../components/admin/Header.vue';

export default {
    data() {
        return {
            page: 1,
        }
    },

    name: 'App',
    components: {
        Header,
    },
};
</script>
