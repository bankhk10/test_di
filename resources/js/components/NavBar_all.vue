<template>
    <div id="reportsPage" class="text-white min-h-screen">
        <nav class="bg-gray-800 py-4 shadow-lg fixed top-0 left-0 w-full z-50">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div class="flex items-center space-x-6">
                    <img class="w-19 h-16 text-1x2 font-bold text-white" :src="imageCard" alt="Company" />
                    <ul :class="{
                        'hidden': !menuOpen,
                        'block mt-8 absolute md:static top-16 right-0 w-full md:w-auto bg-gray-800 md:flex md:space-x-6 transition-all duration-300 ease-in-out px-6': menuOpen
                    }" class="md:static md:flex md:space-x-6 transition-all duration-300 ease-in-out">
                        <li class="border-b md:border-none" @click="setActiveMenu('Dashboard')">
                            <a href="#" class="block px-8 py-4"
                                :class="{ 'bg-gray-700 text-yellow-400': activeMenu === 'Dashboard', 'hover:bg-gray-700 hover:text-yellow-400': activeMenu !== 'Dashboard' }">Dashboard</a>
                        </li>
                        <li class="border-b md:border-none" @click="setActiveMenu('Users')">
                            <a href="#" class="block px-8 py-4"
                                :class="{ 'bg-gray-700 text-yellow-400': activeMenu === 'Users', 'hover:bg-gray-700 hover:text-yellow-400': activeMenu !== 'Users' }">Users</a>
                        </li>
                        <li class="border-b md:border-none md:hidden" @click="closeMenu">
                            <a href="#" class="block px-8 py-4 hover:bg-gray-700 hover:text-red-700">Logout</a>
                        </li>
                    </ul>
                </div>
                <a href="#" class="hidden md:block px-8 py-4 hover:bg-gray-700 hover:text-red-700"
                    @click="closeMenu">Logout</a>
                <button class="text-white focus:outline-none md:hidden" @click="toggleMenu">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </nav>

        <div class="container mx-auto py-20 px-6 md:px-0">
            <div class="grid grid-cols-1 gap-10 ">
                <div class="p-8 rounded-lg shadow-md">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 py-6">
                        <div v-for="user in paginatedUsers" :key="user.name"
                            class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex flex-col items-center pb-10 bg-gray-800 rounded-md">
                                <img class="w-24 h-24 mb-3 rounded-full shadow-lg mt-8" :src="user.imageCard"
                                    :alt="user.name" />
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

                    <!-- Pagination controls -->
                    <div class="flex justify-center mt-6 space-x-4">
                        <button @click="prevPage" :disabled="currentPage === 1"
                            class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 disabled:opacity-50">
                            Previous
                        </button>
                        <span class="text-gray-300">Page {{ currentPage }} of {{ totalPages }}</span>
                        <button @click="nextPage" :disabled="currentPage >= totalPages"
                            class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 disabled:opacity-50">
                            Next
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <footer class="text-center py-6 bg-gray-800 mt-12">
            <p>&copy; 2024 All rights reserved. Design by <a href="https://templatemo.com"
                    class="text-blue-400">Template Mo</a></p>
        </footer>
    </div>
</template>
<script setup>
import { ref, computed } from 'vue';

const imageCard = "/img/logoVbeyond-bg.png";
const users = ref([
    { name: "Bonnie Green", jobTitle: "Visual Designer", imageCard: imageCard },
    { name: "John Doe", jobTitle: "Software Engineer", imageCard: imageCard },
    { name: "Jane Smith", jobTitle: "Product Manager", imageCard: imageCard },
    { name: "Alice Johnson", jobTitle: "HR Manager", imageCard: imageCard },
    { name: "Michael Brown", jobTitle: "Marketing Lead", imageCard: imageCard },
    { name: "Sarah White", jobTitle: "Finance Analyst", imageCard: imageCard },
    { name: "David Black", jobTitle: "CEO", imageCard: imageCard },
    { name: "Chris Red", jobTitle: "CTO", imageCard: imageCard },
    { name: "Chris Red", jobTitle: "CTO", imageCard: imageCard },
    { name: "Chris Red", jobTitle: "CTO", imageCard: imageCard },
    { name: "Chris Red", jobTitle: "CTO", imageCard: imageCard },
    { name: "Chris Red", jobTitle: "CTO", imageCard: imageCard },
    { name: "Michael Brown", jobTitle: "Marketing Lead", imageCard: imageCard },
    { name: "Sarah White", jobTitle: "Finance Analyst", imageCard: imageCard },
    { name: "David Black", jobTitle: "CEO", imageCard: imageCard },
    { name: "Chris Red", jobTitle: "CTO", imageCard: imageCard },
    { name: "Chris Red", jobTitle: "CTO", imageCard: imageCard },
    { name: "Chris Red", jobTitle: "CTO", imageCard: imageCard },
    { name: "Chris Red", jobTitle: "CTO", imageCard: imageCard },
    { name: "Chris Red", jobTitle: "CTO", imageCard: imageCard },
]);


const menuOpen = ref(false);
const currentPage = ref(1);
const itemsPerPage = 8;
const activeMenu = ref('Dashboard');

const setActiveMenu = (menu) => {
    activeMenu.value = menu;
    closeMenu();

};
// Compute the paginated list based on current page
const paginatedUsers = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    return users.value.slice(start, start + itemsPerPage);
});

// Get total pages count
const totalPages = computed(() => Math.ceil(users.value.length / itemsPerPage));

// Pagination functions
const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
};

const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
};

const toggleMenu = () => {
    menuOpen.value = !menuOpen.value;
};

const closeMenu = () => {
    menuOpen.value = false;
};

</script>

<style scoped>
body {
    font-family: 'Roboto', sans-serif;
}
</style>
