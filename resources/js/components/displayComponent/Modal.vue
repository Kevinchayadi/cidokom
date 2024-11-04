<template>
  <div class="relative flex">
    <!-- Icon Hamburger -->
    <button @click="toggleSidebar" class="p-4 md:hidden">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Backside Overlay -->
    <div 
      v-if="isSidebarOpen" 
      @click="toggleSidebar" 
      class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden transition-opacity duration-500 ease-in-out"
    ></div>

    <!-- Sidebar -->
    <div :class="sidebarClasses">
      <nav class="p-4 space-y-2">
        <a href="#" class="block text-gray-700">Home</a>
        <a href="#" class="block text-gray-700">About</a>
        <a href="#" class="block text-gray-700">Contact</a>
      </nav>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 p-4">
      <h1 class="text-2xl font-bold">Main Content</h1>
      <p>This is the main content area.</p>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';

// State untuk sidebar (tersembunyi secara default)
const isSidebarOpen = ref(false);

// Fungsi untuk mengubah state sidebar
function toggleSidebar() {
  isSidebarOpen.value = !isSidebarOpen.value;
}

// Kelas dinamis untuk sidebar dengan transisi dan posisi
const sidebarClasses = computed(() => {
  return `
    fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-md transform 
    ${isSidebarOpen.value ? 'translate-x-0' : '-translate-x-full'} 
    transition-transform duration-500 ease-in-out md:translate-x-0
  `;
});
</script>

<style>
/* Custom CSS (if needed) */
</style>
