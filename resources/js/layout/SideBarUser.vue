<template>
  <div class="relative flex min-h-screen overflow-hidden ">

    <div v-if="isSidebarOpen" @click="toggleSidebar" class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden"></div>

    <!-- Sidebar -->
    <div :class="sidebarClasses" >
      <div class="relative flex items-center">
        <button @click="toggleSidebar" class="p-2  ml-auto " >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
      </div>
      <div>
        
        <NavbarUser />
      </div>
    </div>

    <!-- Main Content Area -->
    <div :class="mainContentClasses">
      <div class="w-full bg-primary">
        <button @click="toggleSidebar" class=" " :class="{ 'opacity-0 pointer-events-none': isSidebarOpen }">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-white stroke-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
      <div class="max-w-full">
         <div v-if="dashboard">
           <FrontTemplate>
             <slot>
               
             </slot>
           </FrontTemplate>
           
        </div>
        <div v-else>
          <FormTemplate>
            <slot>
              
            </slot>
          </FormTemplate>

        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import FormTemplate from '../layout/FormTemplate.vue'
import NavbarUser from '../components/displayComponent/NavbarUser.vue';
import FrontTemplate from './frontTemplate.vue';

const isSidebarOpen = ref(null);

function isMobile() {
    return window.innerWidth < 768; // Ukuran layar mobile lebih kecil dari 768px
}

// Cek ukuran layar pada saat komponen dimuat
onMounted(() => {
    if (isMobile()) {
        isSidebarOpen.value = false; // Set ke false jika perangkat mobile
    } else {
        isSidebarOpen.value = true; // Set ke true jika perangkat bukan mobile
    }
});

function toggleSidebar() {
  isSidebarOpen.value = !isSidebarOpen.value;
}

const props = defineProps({
  dashboard:{
    typeof: Boolean
  }
})

const sidebarClasses = computed(() => {
  return `
    fixed  inset-y-0 left-0 z-30 w-64 bg-primary shadow-md transform 
    ${isSidebarOpen.value ? 'translate-x-0' : '-translate-x-full'} 
    transition-transform duration-100 md:duration-0 ease-in-out 
  `;
});

const mainContentClasses = computed(() => {
  return `
    flex-1  transition-transform duration-100 md:duration-0 ease-in-out 
    ${isSidebarOpen.value ? 'md:translate-x-64 md:max-w-[calc(100%-16rem)]' : 'md:translate-x-0'}

  `;
});
</script>


