<template>
    <div>
      <a href="#" @click.prevent="openModal" class="bg-blue-500 text-white px-4 py-2 rounded-md">Buka Modal</a>
  
      <div 
        v-if="isModalOpen" 
        class="fixed inset-0 bg-black bg-opacity-50 z-20 flex justify-center items-center transition-opacity duration-500 ease-in-out"
        @click.self="closeModal"
      >
        <div class="bg-white p-6 rounded-md w-96">
          <h2 class="text-xl font-bold mb-4">Modal Popup</h2>
          <p>Ini adalah isi modal. Klik di luar modal untuk menutupnya.</p>
          <button @click="closeModal" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-md">Tutup Modal</button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  const isModalOpen = ref(false)
  
  const openModal = () => {
    isModalOpen.value = true
  }
  
  const closeModal = () => {
    isModalOpen.value = false
  }
  </script>
  
  <style scoped>
  </style>
  