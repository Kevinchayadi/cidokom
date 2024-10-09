<template>
    <nav class="bg-gray-800 p-4 fixed w-full top-0 left-0 z-50">
      <div class="container mx-auto flex justify-between items-center">

        <div class="text-white text-2xl font-bold">
          <a href="#">MyLogo</a>
        </div>
  
  
        <div class="md:hidden ">
          <button @click="toggleMenu" class="text-white focus:outline-none">
            <svg v-if="!isMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            
          </button>
        </div>
  

        <div class="hidden md:flex space-x-6 text-white">
          <a href="#" class="hover:text-gray-400">Home</a>
          <a href="#" class="hover:text-gray-400">About</a>
          <a href="#" class="hover:text-gray-400">Services</a>
          <a href="#" class="hover:text-gray-400">Contact</a>
        </div>
      </div>
  

      <div v-if="isMenuOpen" class="md:hidden bg-gray-700 text-white p-4 space-y-2 animate-slide-down mt-5 z-40">
          <a href="#" class="block hover:text-gray-400" @click="closeMenu">Home</a>
          <a href="#" class="block hover:text-gray-400" @click="closeMenu">About</a>
          <a href="#" class="block hover:text-gray-400" @click="closeMenu">Services</a>
          <a href="#" class="block hover:text-gray-400" @click="closeMenu">Contact</a>
        </div>
    </nav>
    <div v-if="isMenuOpen" class="fixed inset-0 bg-black opacity-50 z-20 " @click="closeMenu"></div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  

  const isMenuOpen = ref(false);
  

  const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
  };
  
  
  const closeMenu = () => {
    isMenuOpen.value = false;
  };
  </script>
  
  <style scoped>

  @keyframes slideDown {
    0% {
      opacity: 0; 
      transform: translateY(-10%); 
    }
    100% {
      opacity: 1; 
      transform: translateY(0); 
    }
  }
  
 
  .animate-slide-down {
    animation: slideDown 0.7s ease-in-out forwards;
  }
  </style>
  