<script setup>
import { ref } from "vue";
import axios from "axios";


const imagePath = "/img/Logo-Vbeyond.png";

// Form data
const code = ref("");
const password = ref("");
const errorMessage = ref("");

// Submit form via Axios
const handleSubmit = async () => {
  try {
    const response = await axios.post("/login/auth", {
      code: code.value,
      password: password.value,
    });

    // Redirect to the URL provided by the backend
    if (response.data.redirect) {
      window.location.href = response.data.redirect;
    } else {
      console.log("Login successful", response.data);
    }
  } catch (error) {
    // Handle errors (e.g., validation errors or server issues)
    if (error.response) {
        console.log(error.response);
        errorMessage.value =
            error.response.data.error || "Invalid credentials provided.";
    } else {
      errorMessage.value = "Something went wrong. Please try again.";
    }
  }
};
</script>


<template>
  <div
    class="flex min-h-screen flex-1 flex-col justify-center px-6 py-12 bg-gray-100"
  >
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-20 w-auto" :src="imagePath" alt="Vbeyond" />
    </div>

    <!-- Card Container -->
    <div
      class="mt-7 sm:mx-auto sm:w-full sm:max-w-sm bg-white p-6 rounded-lg shadow"
    >
      <form class="space-y-6" @submit.prevent="handleSubmit">
        <div>
          <label for="code" class="block text-sm font-medium leading-6 text-gray-900">Code</label>
          <div class="mt-2">
            <input
              id="code"
              v-model="code"
              type="text"
              autocomplete="off"
              required
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
            <div class="text-sm">
              <a href="#" class="font-semibold text-green-600 hover:text-green-500">Forgot password?</a>
            </div>
          </div>
          <div class="mt-2">
            <input
              id="password"
              v-model="password"
              type="password"
              autocomplete="current-password"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="flex w-full justify-center rounded-md bg-green-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            Sign in
          </button>
        </div>
        <!-- Error Message -->
        <p v-if="errorMessage" class="text-red-500 text-sm mt-4">{{ errorMessage }}</p>
      </form>
    </div>
  </div>
</template>
