<template>
    <div class="relative h-screen  bg-gray-50">

        <!-- <div v-if="isSidebarOpen" @click="toggleSidebar" class="fixed inset-0 bg-black bg-opacity-20 z-20 md:hidden"></div> -->

        <!-- Main Layout -->
        <div class="grid grid-cols-12 md:h-screen overflow-hidden ">
            <!-- Sidebar -->
            <div :class="sidebarClasses" class="bg-primary shadow-sm">
                <div class=" mb-2 mt-1 mx-2 md:h-screen">
                    <div class="flex justify-end  ">
                        <button @click="toggleSidebar"
                            class="px-2   rounded-full hover:border-gray-600 ">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill=""
                                class="size-5 fill-primary-text-light hidden md:block hover:fill-primary-text-light-hover">
                                <path fill-rule="evenodd"
                                    d="M7.793 2.232a.75.75 0 0 1-.025 1.06L3.622 7.25h10.003a5.375 5.375 0 0 1 0 10.75H10.75a.75.75 0 0 1 0-1.5h2.875a3.875 3.875 0 0 0 0-7.75H3.622l4.146 3.957a.75.75 0 0 1-1.036 1.085l-5.5-5.25a.75.75 0 0 1 0-1.085l5.5-5.25a.75.75 0 0 1 1.06.025Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="" class="size-8 stroke-primary-text-light  md:hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                        
                    </div>

                    <NavbarAdmin />
                </div>

            </div>

            <!-- Main Content Area -->
            <div :class="mainContentClasses" class="h-screen  ">
                <div class="flex justify-between md:justify-normal bg-primary flex-row">
    <!-- Button with order-md-1 to appear first on md and above -->
    <button @click="toggleSidebar"
        class="px-3 py-1 bg-primary hover:bg-primary-aHover"
        :class="{ 'hidden': isSidebarOpen }" :disabled="isSidebarOpen">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="white" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- H1 appears after the button above md screen -->
    <h1 :class="textclasses">PARUNG HIJAU PERKASA - {{ title.toUpperCase() }}</h1>
</div>

                <div >
                    <slot>
            
                    </slot>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
    import {
        computed,
        ref
    } from 'vue';
import TwoTableSide from '../fragment/TwoTableSide.vue';
import NavbarAdmin from '../components/displayComponent/NavbarAdmin.vue';

     const props = defineProps({
        title:{
            type: String,
            default: 'Admin Side'
        }
     })
    const isSidebarOpen = ref(true);

    function toggleSidebar() {
        isSidebarOpen.value = !isSidebarOpen.value;
    }

    const sidebarClasses = computed(() => {
        return isSidebarOpen.value ?
            'col-span-12 md:col-span-2 shadow-md transition-all duration-200 ease-in-out' : 'hidden';
    });
    const textclasses = computed(() => {
        return isSidebarOpen.value ?
             'hidden':'text-white mb-4 md:mb-0 md:order-1 order-2' ;
    });

    const mainContentClasses = computed(() => {
        return isSidebarOpen.value ? 'col-span-12 md:col-span-10 transition-all duration-200 ease-in-out' :
            'col-span-12 transition-all duration-200 ease-in-out';
    });
</script>
