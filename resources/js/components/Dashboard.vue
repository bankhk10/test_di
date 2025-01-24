<template>
    <div id="dashboardPage" class="text-white min-h-screen">
      <Navbar :logo="imageCard" />

      <div class="container mx-auto py-20 px-6 md:px-0">
        <h1 class="text-3xl font-bold mb-6 text-center">Dashboard Overview</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="(stat, index) in stats" :key="index" class="p-6 bg-gray-800 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold text-yellow-400">{{ stat.title }}</h2>
            <p class="text-3xl font-bold mt-2">{{ stat.value }}</p>
          </div>
        </div>
      </div>

      <Footer />
    </div>
  </template>

  <script setup>
  import Navbar from './Navbar.vue';
  import Footer from './Footer.vue';

  const imageCard = "/img/logoVbeyond-bg.png";

  const stats = [
    { title: 'Total Users', value: '1,200' },
    { title: 'Orders Processed', value: '5,300' },
    { title: 'Revenue', value: '$150,000' },
    { title: 'New Signups', value: '320' },
    { title: 'Tickets Resolved', value: '1,500' },
    { title: 'Active Sessions', value: '78' }
  ];
  </script>
