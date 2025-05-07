<template>
    <!-- Modal Overlay -->
    <div v-if="isVisible" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
      <!-- Modal Content -->
      <div class="bg-white rounded-lg shadow-lg p-6 h-[80vh] min-w-[50vw] relative justify-items-center ">
        <!-- Tombol X -->
        <button class="absolute top-4 right-4 text-gray-500 text-2xl font-bold" @click="closeModal">×</button>
        <!-- Slot untuk konten modal -->
        <slot></slot>
      </div>
    </div>
  </template>
  
  
  <script setup>
  import { ref } from 'vue';
  
  // Props untuk kontrol visibilitas modal
  const props = defineProps({
    isVisible: {
      type: Boolean,
      default: false
    }
  });
  
  const emit = defineEmits(['update:isVisible']);

  // Emit event untuk menutup modal
  const closeModal = () => {
    emit('update:isVisible', false); // Emit event untuk update visibility
  };
  </script>
  
  <style scoped>
  /* Tidak ada tambahan styling diperlukan, karena semua styling menggunakan Tailwind CSS */
  </style>
  