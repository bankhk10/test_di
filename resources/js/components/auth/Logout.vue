<script setup>
import { ref } from "vue";
import axios from "axios";

// State for logout status
const logoutMessage = ref("");

const handleLogout = async () => {
  try {
    const response = await axios.post("/logout");

    if (response.data.success) {
      // Show success message and redirect to login page
      logoutMessage.value = response.data.message;
      window.location.href = "/login";
    }
  } catch (error) {
    // Handle errors
    if (error.response) {
      logoutMessage.value = error.response.data.message || "Logout failed.";
    } else {
      logoutMessage.value = "An error occurred. Please try again.";
    }
  }
};
</script>

<template>
  <div>
    <!-- Logout Button -->
    <button
      @click="handleLogout"
      class="bg-red-500 text-white px-4 py-2 rounded-md"
    >
      Logout
    </button>

    <!-- Logout Message -->
    <p v-if="logoutMessage" class="mt-4 text-gray-700">{{ logoutMessage }}</p>
  </div>
</template>
