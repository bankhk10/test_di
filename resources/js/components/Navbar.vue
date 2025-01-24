<template>
    <nav class="fixed top-0 left-0 w-full bg-gray-800 py-4 shadow-lg z-50">
      <div class="container mx-auto flex justify-between items-center px-6">
        <div class="flex items-center space-x-6">
          <img class="w-19 h-16" :src="logo" alt="Company" />
          <ul class="hidden md:flex space-x-6">
            <li v-for="item in menuItems" :key="item.name">
              <router-link
                :to="item.path"
                class="block px-8 py-4 transition duration-300 ease-in-out"
                :class="[activeMenu === item.name ? 'bg-gray-700 text-yellow-400' : 'hover:bg-gray-700 hover:text-yellow-400']"
                @click="setActiveMenu(item.name)"
              >
                {{ item.label }}
              </router-link>
            </li>
          </ul>
        </div>

        <!-- Logout button moved to the far right -->
        <div class="hidden md:block ml-auto">
          <a href="#" class="px-8 py-4 text-white hover:bg-gray-700 hover:text-red-700">
            Logout
          </a>
        </div>

        <!-- Hamburger Menu Button for mobile -->
        <button
          @click="toggleMenu"
          class="md:hidden text-white focus:outline-none"
        >
          <i class="fas fa-bars text-2xl"></i>
        </button>
      </div>

      <!-- Mobile Menu -->
      <ul
        v-if="menuOpen"
        class="md:hidden absolute top-16 left-0 w-full bg-gray-800 flex flex-col space-y-4 p-6 mt-8"
      >
        <li v-for="item in menuItems" :key="item.name">
          <router-link
            :to="item.path"
            class="block px-8 py-4 text-white"
            @click="setActiveMenu(item.name)"
          >
            {{ item.label }}
          </router-link>
        </li>
        <li>
          <a href="#" class="block px-8 py-4 text-white">Logout</a>
        </li>
      </ul>
    </nav>
  </template>

  <script setup>
  import { ref } from 'vue';

  defineProps({
    logo: String,
  });

  const menuItems = ref([
    { name: 'Dashboard', label: 'Dashboard', path: '/dashboard' },
    { name: 'Users', label: 'Users', path: '/userPage' },
  ]);

  const activeMenu = ref('Dashboard');
  const menuOpen = ref(false);

  const setActiveMenu = (menu) => {
    console.log(menu);

    activeMenu.value = menu;
  };

  const toggleMenu = () => {
    menuOpen.value = !menuOpen.value;
  };
  </script>

  <style scoped>
  /* Add any custom styles here */
  </style>
