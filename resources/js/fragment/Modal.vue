<template>
    <div>
      <!-- Tombol untuk membuka modal -->
      <ActionButton @clicked="isOpen = !isOpen" name="Open Modal" />
    
      <!-- Modal Background -->
      <div
        v-if="isOpen"
        class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50"
      >
        <!-- Modal Box -->
        <div class="bg-white w-full max-w-lg mx-auto p-6 rounded-lg shadow-lg">
          <h2 class="text-xl font-bold mb-4">This is a Modal</h2>
          <p class="text-gray-700 mb-4">
            You can add any content inside this modal, including forms, text, and more.
          </p>
    
          <!-- Tombol untuk menutup modal -->
          <ActionButton @clicked="isOpen = !isOpen" name="Close Modal" />
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import ActionButton from '../components/ActionButton.vue';
  
  // Mengelola state untuk buka/tutup modal
  const isOpen = ref(false);
  </script>
  