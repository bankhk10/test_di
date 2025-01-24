<template>
    <div id="reportsPage" class="min-h-screen text-white">
      <Navbar :logo="imageCard" />

      <div class="container mx-auto py-20 px-6 md:px-0">
        <div class="grid grid-cols-1 gap-10">
          <div class="p-8 rounded-lg shadow-md">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 py-6">
              <UserCard v-for="user in paginatedUsers" :key="user.name" :user="user" />
            </div>

            <Pagination
              :current-page="currentPage"
              :total-pages="totalPages"
              @prev-page="prevPage"
              @next-page="nextPage"
            />
          </div>
        </div>
      </div>

      <Footer />
    </div>
  </template>

  <script setup>
  import { ref, computed } from 'vue';
  import Navbar from './Navbar.vue';
  import UserCard from './UserCard.vue';
  import Pagination from './Pagination.vue';
  import Footer from './Footer.vue';

  const imageCard = "/img/logoVbeyond-bg.png";

  const users = ref(
    [...Array(20).keys()].map((i) => ({
      name: `User ${i + 1}`,
      jobTitle: "Developer",
      imageCard: imageCard,
    }))
  );

  const currentPage = ref(1);
  const itemsPerPage = 8;

  // คำนวณรายการผู้ใช้ตามหน้าปัจจุบัน
  const paginatedUsers = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    return users.value.slice(start, start + itemsPerPage);
  });

  // คำนวณจำนวนหน้าทั้งหมด
  const totalPages = computed(() => Math.ceil(users.value.length / itemsPerPage));

  const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
  };

  const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
  };
  </script>
